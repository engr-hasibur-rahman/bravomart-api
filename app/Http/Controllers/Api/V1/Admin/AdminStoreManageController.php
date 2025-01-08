<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SellerWiseStoreResource;
use App\Interfaces\StoreManageInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminStoreManageController extends Controller
{
    public function __construct(protected StoreManageInterface $storeRepo)
    {

    }

    public function sellerStores(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $stores = $this->storeRepo->getSellerWiseStores($request->seller_id);
        if ($stores) {
            return response()->json([
                'data' => SellerWiseStoreResource::collection($stores),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
            ]);
        }
    }
}
