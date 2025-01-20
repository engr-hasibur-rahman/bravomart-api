<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\PlaceOrderRequest;
use App\Http\Resources\Order\PlaceOrderDetailsResource;
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

        $data = $request->validated();  // Get the validated data

        $order = $this->orderService->createOrder($request->all());
        try {
            // Check if the order creation was successful
            if ($order) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully.',
                    'order' => new PlaceOrderDetailsResource($order),
                ], 201);
            }
            // order wasn't created
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again.',
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while placing the order.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
