<?php

namespace App\Http\Controllers\Api\V1\Com;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Http\Resources\Com\Store\OwnerWiseStoreListResource;
use App\Http\Resources\Com\Store\StoreListResource;
use App\Interfaces\StoreManageInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreManageController extends Controller
{
    public function __construct(protected StoreManageInterface $storeRepo)
    {
    }

    public function index(Request $request)
    {
        $stores = $this->storeRepo->getPaginatedStore(
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

    public function store(StoreRequest $request): JsonResponse
    {
        $store = $this->storeRepo->store($request->all());
        $this->storeRepo->storeTranslation($request, $store, 'App\Models\ComStore', $this->storeRepo->translationKeys());
        if ($store) {
            return $this->success(translate('messages.save_success', ['name' => 'Store']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Store']));
        }
    }

    public function update(StoreRequest $request)
    {
        $store = $this->storeRepo->update($request->all());
        $this->storeRepo->updateTranslation($request, $store, 'App\Models\ComStore', $this->storeRepo->translationKeys());
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

    public function deleted_records()
    {
        $records = $this->storeRepo->records(true);
        return response()->json([
            "data" => $records,
            "massage" => "Records were restored successfully!"
        ], 201);
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
