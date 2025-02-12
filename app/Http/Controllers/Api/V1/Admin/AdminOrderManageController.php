<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Order\AdminOrderResource;
use App\Http\Resources\Order\InvoiceResource;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminOrderManageController extends Controller
{
    public function allOrders(Request $request)
    {
        $order_id = $request->order_id;

        if ($order_id) {
            $order = Order::with(['customer', 'orderPackages.orderDetails', 'orderPackages.store', 'orderPayment', 'deliveryman'])
                ->where('id', $order_id)
                ->first();
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }
            $deliveryman_id = $order->confirmed_by;
            $total_delivered = Order::where('confirmed_by', $deliveryman_id)->where('status', 'delivered')->count();
            $last_delivered_location = Order::with('shippingAddress')
                ->where('confirmed_by', $deliveryman_id)
                ->where('status', 'delivered')
                ->orderBy('delivery_completed_at', 'desc')
                ->first();
            if ($order->deliveryman) {
                $order->deliveryman->last_delivered_location = optional($last_delivered_location?->shippingAddress)->address ?? 'No address available';
                $order->deliveryman->total_delivered = $total_delivered ?? 0;
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

    public function changeOrderStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $order = Order::find($request->order_id);
        if (!$order) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
        if ($order->status === 'pending') {
            $success = $order->update([
                'status' => 'active'
            ]);
            if ($success) {
                return response()->json([
                    'message' => __('messages.update_success', ['name' => 'Order status'])
                ], 200);
            } else {
                return response()->json([
                    'message' => __('messages.update_failed', ['name' => 'Order status'])
                ], 500);
            }
        } else {
            return response()->json([
                'message' => __('messages.order_status_not_changeable')
            ], 422);
        }
    }

    public function changePaymentStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:pending,paid,failed',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $order = Order::find($request->order_id);
        if (!$order) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
        $success = $order->update([
            'payment_status' => $request->status
        ]);
        if ($success) {
            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Order payment status'])
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.update_failed', ['name' => 'Order payment status'])
            ], 500);
        }
    }

    public function assignDeliveryMan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'delivery_man_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $order = Order::find($request->order_id);
        if (!$order) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
        $success = $order->update([
            'confirmed_by' => $request->delivery_man_id
        ]);
        if ($success) {
            return response()->json([
                'message' => __('messages.deliveryman_assign_successful')
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.deliveryman_assign_failed')
            ], 500);
        }
    }

    public function cancelOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $order = Order::find($request->order_id);
        if (!$order) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
        if ($order->status === 'pending') {
            $success = $order->update([
                'cancelled_by' => auth('api')->user()->id,
                'cancelled_at' => Carbon::now(),
                'status' => 'cancelled'
            ]);
            if ($success) {
                return response()->json([
                    'message' => __('messages.order_cancel_successful')
                ], 200);
            } else {
                return response()->json([
                    'message' => __('messages.order_cancel_failed')
                ], 500);
            }
        } else {
            return response()->json([
                'message' => __('messages.order_status_not_changeable')
            ], 422);
        }
    }
}
