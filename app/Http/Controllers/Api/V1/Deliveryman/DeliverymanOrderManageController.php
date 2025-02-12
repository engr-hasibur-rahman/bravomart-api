<?php

namespace App\Http\Controllers\Api\V1\Deliveryman;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Deliveryman\DeliverymanMyOrdersResource;
use App\Interfaces\DeliverymanManageInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliverymanOrderManageController extends Controller
{
    public function __construct(protected DeliverymanManageInterface $deliverymanRepo)
    {

    }

    public function getMyOrders()
    {
        if (!auth('api')->user() && auth('api')->user()->activity_scope !== 'delivery_level') {
            unauthorized_response();
        }
        $orders = $this->deliverymanRepo->deliverymanOrders();
        if ($orders->isEmpty()) {
            return [];
        }
        if ($orders) {
            return response()->json([
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
            return [];
        }
        if ($order_requests->isEmpty()) {
            return [];
        }
        if ($order_requests) {
            return response()->json([
                'data' => DeliverymanMyOrdersResource::collection($order_requests),
                'meta' => new PaginationResource($order_requests)
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.something_went_wrong')
            ], 500);
        }
    }

    public function handleOrderRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:orders,id',
            'status' => 'required|in:accepted,ignored',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $deliveryman = auth('api')->user();

        if (!$deliveryman || $deliveryman->activity_scope !== 'delivery_level') {
            unauthorized_response();
        }
        $success = $this->deliverymanRepo->updateOrderStatus($request->status, $request->id);

        if ($success === 'accepted') {
            return response()->json([
                'message' => __('messages.deliveryman_order_request_accept_successful')
            ], 200);
        } elseif ($success === 'already confirmed') {
            return response()->json([
                'message' => __('messages.deliveryman_order_already_taken')
            ], 422);
        } elseif ($success === 'ignored') {
            return response()->json([
                'message' => __('messages.deliveryman_order_request_ignore_successful')
            ], 200);
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
                'status' => false,
                'message' => 'Unauthorized access. Please log in.',
            ], 401);
        }

        if ($order_histories->isEmpty()) {
            return response()->json([
                'message' => __('messages.no_order_history_found')
            ], 404);
        }

        return response()->json([
            'data' => DeliverymanMyOrdersResource::collection($order_histories),
            'meta' => new PaginationResource($order_histories)
        ], 200);
    }
}
