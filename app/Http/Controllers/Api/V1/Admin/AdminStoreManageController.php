<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\SellerStoreRequest;
use App\Http\Resources\Admin\AdminStoreDetailsResource;
use App\Http\Resources\Admin\AdminStoreRequestResource;
use App\Http\Resources\Admin\SellerWiseStoreForDropdownResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Com\Store\StoreListResource;
use App\Interfaces\StoreManageInterface;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminStoreManageController extends Controller
{
    public function __construct(protected StoreManageInterface $storeRepo)
    {

    }

    public function index(Request $request)
    {
        $stores = $this->storeRepo->getAllStores(
            $request->per_page ?? 10,
            $request->status,
            $request->page ?? 1,
            $request->language ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
        // Return the stores as a resource collection
        return response()->json([
            'data' => StoreListResource::collection($stores),
            'meta' => new PaginationResource($stores),
        ]);
    }

    public function store(AdminStoreRequest $request): JsonResponse
    {
        $request['status'] = 1;
        $store = $this->storeRepo->store($request->all());
        createOrUpdateTranslation($request, $store, 'App\Models\Store', $this->storeRepo->translationKeys());
        if ($store) {
            return $this->success(translate('messages.save_success', ['name' => 'Store']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Store']));
        }
    }

    public function update(SellerStoreRequest $request)
    {
        $store = $this->storeRepo->update($request->all());
        createOrUpdateTranslation($request, $store, 'App\Models\Store', $this->storeRepo->translationKeys());
        if ($store) {
            return $this->success(translate('messages.update_success', ['name' => 'Store']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Store']));
        }
    }

    public function show(Request $request)
    {
        return $this->storeRepo->getStoreById($request->id);
//        return response()->json(new AdminStoreDetailsResource($store));
    }

    public function sellerStores(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'nullable|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $stores = $this->storeRepo->getSellerWiseStores($request->seller_id);
        if ($stores) {
            return response()->json(SellerWiseStoreForDropdownResource::collection($stores));
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
            ]);
        }
    }

    public function deletedRecords()
    {
        $records = $this->storeRepo->records(true);
        return response()->json([
            "data" => $records,
            "massage" => "Records were restored successfully!"
        ], 201);
    }

    public function destroy($id)
    {
        $this->storeRepo->delete($id);
        return $this->success(translate('messages.delete_success'));
    }

    public function storeRequest()
    {
        $stores = Store::with(['related_translations', 'seller'])->pendingStores()->paginate(10);
        return response()->json([
            'data' => AdminStoreRequestResource::collection($stores),
            'meta' => new PaginationResource($stores),
        ]);
    }

    public function approveStoreRequests(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids*' => 'required|array|exists:stores,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $success = $this->storeRepo->approveStores($request->ids);
            if ($success) {
                return $this->success(__('messages.approve.success', ['name' => 'Stores']));
            } else {
                return $this->failed(__('messages.approve.failed', ['name' => 'Stores']));
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:stores,id',
            'status' => 'required|in:0,1,2',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $success = $this->storeRepo->changeStatus($request->all());
        if ($success) {
            return $this->success(__('messages.update_success', ['name' => 'Stores status']));
        } else {
            return $this->failed(__('messages.update_failed', ['name' => 'Stores status']));
        }
    }
}
