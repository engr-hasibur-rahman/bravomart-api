<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Order\CustomerOrderResource;
use App\Models\CouponLine;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerOrderController extends Controller
{
    public function myOrders()
    {

        $customer_id = auth()->guard('api_customer')->user()->id;
        $orders = Order::with('orderPackages.order_details')->where('customer_id', $customer_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'orders' => CustomerOrderResource::collection($orders),
            'meta' => new PaginationResource($orders)
        ]);
    }

    public function OrderDetails($id = null)
    {
        $customer_id = auth()->guard('api_customer')->user()->id;

        $order = Order::with(['orderPayment', 'orderPackages', 'orderDetails'])
            ->where('id', $id)
            ->where('customer_id', $customer_id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$order) {
            return response()->json([
                'error' => 'Order not found or you do not have access to it'
            ], 404);
        }

        dd($order);

        return response()->json([
            'order_details' => $order
        ]);
    }

    public function checkCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|string|exists:coupon_lines,coupon_code',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        // Retrieve the coupon by the provided coupon code
        $coupon = CouponLine::where('coupon_code', $request->coupon_code)->first();
        // Handle the case where the coupon is not found
        if (!$coupon) {
            return response()->json([
                'message' => __('messages.coupon_not_found'),
            ], 404);
        }
        // Check if the coupon is restricted to a specific customer
        if ($coupon->customer_id !== null) {
            // If the coupon is tied to a specific customer, ensure the authenticated user is the same
            if (!auth('api_customer')->check()) {
                unauthorized_response();
            }

            // Check if the authenticated customer ID matches the coupon's customer ID
            if ($coupon->customer_id !== auth('api_customer')->user()->id) {
                return response()->json([
                    'message' => __('messages.coupon_does_not_belong'),
                ], 400);
            }
        }

        // Check if the coupon is active based on the start and end dates
        if ($coupon->start_date && $coupon->start_date > now()) {
            return response()->json([
                'status' => false,
                'message' => __('messages.coupon_inactive'),
            ], 400);
        }

        if ($coupon->end_date && $coupon->end_date < now()) {
            return response()->json([
                'message' => __('messages.coupon_expired'),
            ], 410);
        }

        // Check if the coupon usage limit has been reached
        if ($coupon->usage_limit && $coupon->usage_count >= $coupon->usage_limit) {
            return response()->json([
                'message' => __('messages.coupon_limit_reached'),
            ], 400);
        }
        if ($coupon->coupon->status !== 1 && $coupon->status !== 1) {
            return response()->json([
                'message' => __('messages.coupon_inactive'),
            ], 400);
        }
        // If all checks pass, return the coupon's discount details
        return response()->json([
            'message' => __('messages.coupon_applied'),
            'coupon' => [
                'title' => $coupon->coupon->title,
                'discount_amount' => $coupon->discount,
                'discount_type' => $coupon->discount_type,
                'code' => $coupon->coupon->code,
            ]
        ], 200);
    }
}
