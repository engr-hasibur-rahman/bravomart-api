<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Order\CustomerOrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function myOrders(){

        $customer_id = auth()->guard('api_customer')->user()->id;
        $orders = Order::where('customer_id', $customer_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'orders' => CustomerOrderResource::collection($orders),
            'meta' => new PaginationResource($orders)
        ]);
    }
}
