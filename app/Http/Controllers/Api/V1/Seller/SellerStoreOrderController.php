<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Order\SellerStoreOrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class SellerStoreOrderController extends Controller
{
    public function allOrders(Request $request){
        $seller_id = auth()->guard('api_customer')->user()->id;
        $orders = Order::where('seller_id', $seller_id)
            ->where('store_id', $request->store_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'orders' => SellerStoreOrderResource::collection($orders),
            'meta' => new PaginationResource($orders)
        ]);
    }
}
