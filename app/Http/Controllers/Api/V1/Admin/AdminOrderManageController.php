<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Order\AdminOrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderManageController extends Controller
{
    public function allOrders(Request $request){

        $store_id = $request->store_id;

        $orders = Order::with(['customer','orderPackages.orderDetails', 'orderPayment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'orders' => AdminOrderResource::collection($orders),
            'meta' => new PaginationResource($orders)
        ]);
    }
}
