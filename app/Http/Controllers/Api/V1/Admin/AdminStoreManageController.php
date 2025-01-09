<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\SellerStoreRequest;
use App\Http\Resources\Admin\SellerWiseStoreForDropdownResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Com\Store\StoreListResource;
use App\Interfaces\StoreManageInterface;
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
            $request->limit ?? 10,
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
        $store = $this->storeRepo->store($request->all());
        $this->storeRepo->storeTranslation($request, $store, 'App\Models\ComMerchantStore', $this->storeRepo->translationKeys());
        if ($store) {
            return $this->success(translate('messages.save_success', ['name' => 'Store']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Store']));
        }
    }

    public function update(SellerStoreRequest $request)
    {
        $store = $this->storeRepo->update($request->all());
        $this->storeRepo->updateTranslation($request, $store, 'App\Models\ComMerchantStore', $this->storeRepo->translationKeys());
        if ($store) {
            return $this->success(translate('messages.update_success', ['name' => 'Store']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Store']));
        }
    }

    public function show(Request $request)
    {
        return $this->storeRepo->getStoreById($request->id);
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
}
