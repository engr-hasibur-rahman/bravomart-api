<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\PlaceOrderRequest;
use App\Http\Resources\Order\OrderMasterResource;
use App\Http\Resources\Order\PlaceOrderDetailsResource;
use App\Http\Resources\Order\PlaceOrderMasterResource;
use App\Models\Order;
use App\Models\OrderMaster;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaceOrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    // place order
    public function placeOrder(PlaceOrderRequest $request): JsonResponse
    {
        $data = $request->validated();

        // login check
        if (!auth()->guard('api_customer')->user()
            && isset($data['guest_info'])
            && isset($data['guest_info']['guest_order'])
            && $data['guest_info']['guest_order'] === false) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to proceed with the order.',
            ], 400);
        }

        $orders = $this->orderService->createOrder($data);
        // if return false
        if($orders === false){
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again.',
            ], 400);
        }

        // response order data
        $all_orders = $orders[0];
        $order_master = $orders[1];

        try {
            if ($orders) {
                $response = [
                    'success' => true,
                    'message' => 'Order placed successfully.',
                    'orders' => PlaceOrderDetailsResource::collection($all_orders),
                    'order_master' => new PlaceOrderMasterResource($order_master),
                ];
                return response()->json($response);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while placing the order.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
