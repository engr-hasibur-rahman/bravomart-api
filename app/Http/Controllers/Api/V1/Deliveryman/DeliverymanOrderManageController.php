<?php

namespace App\Http\Controllers\Api\V1\Deliveryman;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Deliveryman\DeliverymanMyOrdersResource;
use App\Http\Resources\Deliveryman\DeliverymanOrderRequestResource;
use App\Http\Resources\Order\AdminOrderResource;
use App\Http\Resources\Order\OrderRefundRequestResource;
use App\Http\Resources\Order\OrderSummaryResource;
use App\Interfaces\DeliverymanManageInterface;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliverymanOrderManageController extends Controller
{
    public function __construct(protected DeliverymanManageInterface $deliverymanRepo)
    {

    }

    public function getMyOrders(Request $request)
    {
        $order_id = $request->order_id;
        if (!auth('api')->user() && auth('api')->user()->activity_scope !== 'delivery_level') {
            unauthorized_response();
        }
        if ($order_id) {
            $order = $this->deliverymanRepo->deliverymanOrderDetails($order_id);
            if ($order) {
                return response()->json(
                    [
                        'order_data' => new AdminOrderResource($order),
                        'order_summary' => new OrderSummaryResource($order),
                    ], 200
                );
            } else {
                return response()->json(['message' => __('messages.data_not_found')], 404);
            }

        }
        $orders = $this->deliverymanRepo->deliverymanOrders();
        if ($orders) {
            return response()->json([
                'message' => __('messages.data_found'),
                'data' => DeliverymanMyOrdersResource::collection($orders),
                'meta' => new PaginationResource($orders)
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.something_went_wrong')
            ], 500);
        }
    }

    public function getOrderRequest()
    {
        if (!auth('api')->user() && auth('api')->user()->activity_scope !== 'delivery_level') {
            unauthorized_response();
        }
        $order_requests = $this->deliverymanRepo->orderRequests();
        if (!$order_requests) {
            return response()->json([
                'message' => __('messages.data_not_found'),
                'data' => [],
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.data_found'),
                'data' => DeliverymanOrderRequestResource::collection($order_requests),
                'meta' => new PaginationResource($order_requests)
            ], 200);

        }
    }

    public function handleOrderRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:orders,id',
            'status' => 'required|in:accepted,ignored',
            'reason' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $deliveryman = auth('api')->user();

        if (!$deliveryman || $deliveryman->activity_scope !== 'delivery_level') {
            unauthorized_response();
        }

        // update order delivery history
        $success = $this->deliverymanRepo->updateOrderStatus(
            $request->status,
            $request->id,
            $request->reason
        );

        if ($success === 'accepted') {
            return response()->json([
                'message' => __('messages.deliveryman_order_request_accept_successful')
            ], 200);
        } elseif ($success === 'already confirmed') {
            return response()->json([
                'message' => __('messages.deliveryman_order_already_taken')
            ], 422);
        } elseif ($success === 'already accepted') {
            return response()->json([
                'message' => __('messages.deliveryman_order_already_accepted')
            ], 422);
        } elseif ($success === 'ignored') {
            return response()->json([
                'message' => __('messages.deliveryman_order_request_ignore_successful')
            ], 200);
        } elseif ($success === 'already ignored') {
            return response()->json([
                'message' => __('messages.deliveryman_order_already_ignored')
            ], 422);
        } elseif ($success === 'reason is required') {
            return response()->json([
                'message' => __('validation.required', ["attribute" => "Reason"])
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.something_went_wrong')
            ], 500);
        }
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:orders,id',
            'status' => 'required|in:delivered,cancelled',
            'reason' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $deliveryman = auth('api')->user();

        if (!$deliveryman || $deliveryman->activity_scope !== 'delivery_level') {
            unauthorized_response();
        }
        $already_cancelled_or_ignored_or_delivered = Order::with('orderDeliveryHistory')
            ->whereHas('orderDeliveryHistory', function ($query) use ($deliveryman, $request) {
                $query->where('deliveryman_id', $deliveryman->id)
                    ->where('order_id', $request->id)
                    ->where('status', '!=', 'accepted'); // Ensures status is NOT 'accepted'
            })
            ->exists();

//        $is_cash_on_delivery = Order::where('id', $request->id)
//            ->whereHas('orderMaster', function ($query) {
//                $query->where('payment_gateway', 'cash_on_delivery');
//            })
//            ->exists();
//        if (!$is_cash_on_delivery) {
//            return response()->json([
//                'message' => __('messages.order_is_not_cash_on_delivery')
//            ], 422);
//        }
        if ($already_cancelled_or_ignored_or_delivered) {
            return response()->json([
                'message' => __('messages.order_already_cancelled_or_ignored_or_delivered')
            ], 422);
        }
        // update order delivery history
        $success = $this->deliverymanRepo->orderChangeStatus($request->status, $request->id);
        if ($success === 'order_is_not_accepted') {
            return response()->json([
                'message' => __('messages.order_is_not_accepted')
            ], 200);
        }
        if ($success === 'delivered') {
            return response()->json([
                'message' => __('messages.order_delivered_success')
            ], 200);
        } elseif ($success === 'already delivered') {
            return response()->json([
                'message' => __('messages.deliveryman_order_already_taken')
            ], 422);
        } else {
            return response()->json([
                'message' => __('messages.something_went_wrong')
            ], 500);
        }
    }

    public function orderDeliveryHistory()
    {
        $order_histories = $this->deliverymanRepo->deliverymanOrderHistory();

        if ($order_histories === 'unauthorized') {
            return response()->json([
                'message' => 'Unauthorized access. Please log in.',
            ], 401);
        }

        if ($order_histories->isEmpty()) {
            return response()->json([
                'message' => __('messages.no_order_history_found')
            ], 404);
        }

        return response()->json([
            'message' => __('messages.data_found'),
            'data' => DeliverymanMyOrdersResource::collection($order_histories),
            'meta' => new PaginationResource($order_histories)
        ], 200);
    }
}
