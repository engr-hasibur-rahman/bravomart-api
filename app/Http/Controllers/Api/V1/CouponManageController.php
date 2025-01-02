<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponLineRequest;
use App\Http\Requests\CouponRequest;
use App\Http\Resources\Coupon\CouponLineResource;
use App\Http\Resources\Coupon\CouponResource;
use App\Interfaces\CouponManageInterface;
use App\Repositories\CouponLineManageRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponManageController extends Controller
{
    public function __construct(protected CouponManageInterface $couponRepo, protected CouponLineManageRepository $couponLineRepo)
    {
    }

    public function index(Request $request)
    {
        return $this->couponRepo->getPaginatedCoupon(
            $request->limit ?? 10,
            $request->page ?? 1,
            $request->language ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
    }

    public function store(CouponRequest $request): JsonResponse
    {
        $coupon = $this->couponRepo->store($request->all());
        $this->couponRepo->storeTranslation($request, $coupon, 'App\Models\Coupon', $this->couponRepo->translationKeys());
        if ($coupon) {
            return $this->success(translate('messages.save_success', ['name' => 'Coupon']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Coupon']));
        }
    }

    public function update(CouponRequest $request)
    {
        $coupon = $this->couponRepo->update($request->all());
        $this->couponRepo->updateTranslation($request, $coupon, 'App\Models\Coupon', $this->couponRepo->translationKeys());
        if ($coupon) {
            return $this->success(translate('messages.update_success', ['name' => 'Coupon']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Coupon']));
        }
    }

    public function show(Request $request)
    {
        return $this->couponRepo->getCouponById($request->id);
    }

    public function destroy($id)
    {
        $this->couponRepo->delete($id);
        return $this->success(translate('messages.delete_success', ['name' => 'Coupon']));
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $result = $this->couponRepo->changeStatus($request->id, $request->status);
        if (!$result) {
            return response()->json(['message' => __('messages.data_not_found')], 404);
        }
        return $this->success(translate('messages.update_success', ['name' => 'Coupon']));
    }

    public function couponLineIndex(Request $request)
    {
        $couponLines = $this->couponLineRepo->getPaginatedCouponLines(
            $request->limit ?? 10,
            $request->page ?? 1,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            $request->filters ?? []
        );
        return response()->json([
            'coupon_lines' => CouponLineResource::collection($couponLines),
            'current_page' => $couponLines->currentPage(),
            'per_page' => $couponLines->perPage(),
            'total' => $couponLines->total(),
            'last_page' => $couponLines->lastPage(),
        ]);
    }

    public function couponLineStore(CouponLineRequest $request): JsonResponse
    {
        $couponLine = $this->couponLineRepo->couponLineStore($request->all());

        if ($couponLine) {
            return $this->success(translate('messages.save_success', ['name' => 'Coupon Line']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Coupon Line']));
        }
    }

    public function couponLineUpdate(CouponLineRequest $request)
    {
        $couponLine = $this->couponLineRepo->couponLineUpdate($request->all());

        if ($couponLine) {
            return $this->success(translate('messages.update_success', ['name' => 'Coupon Line']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Coupon']));
        }
    }

    public function couponLineShow(Request $request)
    {
        $couponLine = $this->couponLineRepo->getCouponLineById($request->id);
        return response()->json(new CouponLineResource($couponLine));
    }

    public function couponLineDestroy($id)
    {
        $this->couponLineRepo->couponLineDelete($id);
        return $this->success(translate('messages.delete_success', ['name' => 'Coupon Line']));
    }
}
