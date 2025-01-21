<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Order\SellerStoreOrderResource;
use App\Models\Order;
use App\Models\OrderPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerStoreOrderController extends Controller
{
    public function allOrders(Request $request){

       $validator = Validator::make($request->all(), [
            'store_id' => 'required|exists:com_merchant_stores,id',
        ]);

        // Check for validation failure
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        $seller_id = auth()->guard('api')->user()->id;

        $orders = Order::where('store_id', $request->store_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'orders' => SellerStoreOrderResource::collection($orders),
            'meta' => new PaginationResource($orders)
        ]);
    }
}
