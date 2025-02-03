<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Resources\Admin\AdminStoreTypeDetailsResource;
use App\Interfaces\StoreTypeManageInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminStoreTypeManageController extends Controller
{
    public function __construct(protected StoreTypeManageInterface $storeTypeRepo)
    {

    }

    public function allStoreTypes(Request $request)
    {
        $filters = [
            'per_page' => $request->per_page,
            'type' => $request->type,
            'search' => $request->search,
            'status' => $request->status,
        ];
        $store_types = $this->storeTypeRepo->getAllStoreTypes($filters);
        if ($store_types) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'data' => $store_types
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => __('messages.data_not_found')
            ]);
        }
    }

    public function updateStoreType(StoreTypeRequest $request)
    {
        $success = $this->storeTypeRepo->updateStoreType($request->all());
        if ($success) {
            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Store Type']),
            ], 201);
        } else {
            return response()->json([
                'message' => __('messages.update_failed', ['name' => 'Store Type'])
            ], 500);
        }
    }

    public function storeTypeDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:store_types,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $storeType = $this->storeTypeRepo->getStoreTypeById($request->id);
        if ($storeType) {
            return response()->json(new AdminStoreTypeDetailsResource($storeType), 200);
        } else {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
    }
}
