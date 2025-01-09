<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\SellerStoreRequest;
use App\Http\Resources\Com\Store\OwnerWiseStoreListResource;
use App\Http\Resources\Com\Store\StoreListResource;
use App\Interfaces\StoreManageInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellerStoreManageController extends Controller
{
    public function __construct(protected StoreManageInterface $storeRepo)
    {
    }

    public function index(Request $request)
    {
        $stores = $this->storeRepo->getAuthSellerStores(
            $request->limit ?? 10,
            $request->page ?? 1,
            $request->language ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );

        // Return the stores as a resource collection
        return StoreListResource::collection($stores);
    }

    public function store(SellerStoreRequest $request): JsonResponse
    {
        $store = $this->storeRepo->storeForAuthSeller($request->all());
        $this->storeRepo->storeTranslation($request, $store, 'App\Models\ComMerchantStore', $this->storeRepo->translationKeys());
        if ($store) {
            return $this->success(translate('messages.save_success', ['name' => 'Store']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Store']));
        }
    }

    public function update(SellerStoreRequest $request)
    {
        $store = $this->storeRepo->updateForSeller($request->all());
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

    public function destroy($id)
    {
        $this->storeRepo->delete($id);
        return $this->success(translate('messages.delete_success'));
    }



    public function ownerWiseStore()
    {
        try {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'stores' => OwnerWiseStoreListResource::collection($this->storeRepo->getOwnerStores())
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }
}
