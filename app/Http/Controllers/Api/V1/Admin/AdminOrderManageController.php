<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Order\AdminOrderResource;
use App\Http\Resources\Order\InvoiceResource;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderManageController extends Controller
{
    public function allOrders(Request $request)
    {
        $store_id = $request->store_id;
        $order_id = $request->order_id;

        if ($order_id) {
            $order = Order::with(['customer', 'orderPackages.orderDetails', 'orderPayment', 'deliveryman'])
                ->where('id', $order_id)
                ->first();
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }
            return response()->json(new AdminOrderResource($order));
        }
        $query = Order::with(['customer', 'orderPackages.orderDetails', 'orderPayment']);

        if (isset($request->status)) {
            $query->where('status', $request->status);
        }

        if (isset($request->payment_status)) {
            $query->where('payment_status', $request->payment_status);
        }

        if (isset($request->search)) {
            $query->where('id', 'like', '%' . $request->search . '%');
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'orders' => AdminOrderResource::collection($orders),
            'meta' => new PaginationResource($orders)
        ]);
    }

    public function invoice(Request $request)
    {
        $order_id = $request->order_id;
        $order = Order::with(['customer', 'orderPackages.orderDetails.product', 'orderPayment', 'shippingAddress'])
            ->where('id', $order_id)
            ->first();
        if (!$order) {
            return response()->json(['message' => __('messages.data_not_found')], 404);
        }
        return response()->json(new InvoiceResource($order));
    }
}
