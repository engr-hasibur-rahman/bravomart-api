<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\OrderActivityType;
use App\Enums\OrderStatusType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminOrderStatusResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Order\AdminOrderResource;
use App\Http\Resources\Order\InvoiceResource;
use App\Http\Resources\Order\OrderRefundRequestResource;
use App\Http\Resources\Order\OrderSummaryResource;
use App\Models\Order;
use App\Models\OrderActivity;
use App\Models\SystemCommission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminOrderManageController extends Controller
{
    public function allOrders(Request $request)
    {
        $order_id = $request->order_id;

        if ($order_id) {
            $order = Order::with(['orderMaster.customer', 'orderDetail.product', 'orderMaster', 'store.area', 'deliveryman', 'orderMaster.shippingAddress', 'refund.store', 'refund.orderRefundReason'])
                ->where('id', $order_id)
                ->first();
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }
            $deliveryman_id = $order->confirmed_by;
            $total_delivered = Order::where('confirmed_by', $deliveryman_id)->where('status', 'delivered')->count();
            $last_delivered_location = Order::with('orderMaster.shippingAddress')
                ->where('confirmed_by', $deliveryman_id)
                ->where('status', 'delivered')
                ->orderBy('delivery_completed_at', 'desc')
                ->first();
            if ($order->deliveryman) {
                $order->deliveryman->last_delivered_location = optional($last_delivered_location?->shippingAddress)->address ?? 'No address available';
                $order->deliveryman->total_delivered = $total_delivered ?? 0;
            }
            return response()->json(
                [
                    'order_data' => new AdminOrderResource($order),
                    'order_summary' => new OrderSummaryResource($order),
                    'refund' => $order->refund ? new OrderRefundRequestResource($order->refund) : null,
                ], 200
            );
        }
        $ordersQuery = Order::with(['orderMaster.customer', 'orderDetail', 'orderMaster', 'store.related_translations', 'deliveryman', 'orderMaster.shippingAddress']);

        $ordersQuery->when($request->status, fn($query) => $query->where('status', $request->status));
        $ordersQuery->when($request->refund_status, fn($query) => $query->where('refund_status', $request->refund_status));

        $ordersQuery->when($request->start_date && $request->end_date, function ($query) use ($request) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        });

        $ordersQuery->when($request->payment_status, function ($query) use ($request) {
            $query->whereHas('orderMaster', function ($q) use ($request) {
                $q->where('payment_status', $request->payment_status);
            });
        });

        $ordersQuery->when($request->search, fn($query) => $query->where('id', 'like', '%' . $request->search . '%'));

        $orders = $ordersQuery->orderBy('created_at', 'desc')->paginate($request->per_page ?? 10);
        // === Order Status Buttons (From Full Order Table, Unfiltered) ===
        $orderStatusCounts = new AdminOrderStatusResource(Order::all());
        return response()->json([
            'orders' => AdminOrderResource::collection($orders),
            'meta' => new PaginationResource($orders),
            'status' => $orderStatusCounts,
        ]);
    }

    public function invoice(Request $request)
    {
        $order_id = $request->order_id;
        $order = Order::with(['orderMaster.customer', 'orderDetail', 'orderMaster', 'store', 'deliveryman', 'orderMaster.shippingAddress'])
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
            'status' => 'required|in:' . implode(',', array_column(OrderStatusType::cases(), 'value')),
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

        if ($request->status === 'cancelled') {
            $success = $order->update([
                'cancelled_by' => auth('api')->user()->id,
                'cancelled_at' => Carbon::now(),
                'status' => 'cancelled'
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
        }
        if ($request->status === 'delivered') {
            $success = $order->update([
                'delivery_completed_at' => Carbon::now(),
                'status' => $request->status
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
        }
        $success = $order->update([
            'status' => $request->status
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
        $order = Order::with('orderMaster')->find($request->order_id);
        if (!$order) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }

        $success = $order->orderMaster->update([
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
        $systemSettings = SystemCommission::first();
        $store_handle_delivery = $systemSettings->order_confirmation_by == 'store';
        if ($store_handle_delivery){
            return response()->json([
                'message' => __('messages.order_confirmation_store')
            ],422);
        }
        $order = Order::find($request->order_id);
        if (!$order) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }
        if ($order->confirmed_by !== null || $order->confirmed_at !== null) {
            return response()->json([
                'message' => __('messages.deliveryman_order_already_taken')
            ], 422);
        }
        if ($order->status === 'processing') {
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
        } else {
            return response()->json([
                'message' => __('messages.deliveryman_can_not_be_assigned')
            ], 422);
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
        if ($order->status !== 'delivered') {
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
