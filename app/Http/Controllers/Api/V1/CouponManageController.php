<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Interfaces\CouponManageInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponManageController extends Controller
{
    public function __construct(protected CouponManageInterface $couponRepo) {}
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
        return $this->success(translate('messages.delete_success',['name'=>'Coupon']));
    }
}
