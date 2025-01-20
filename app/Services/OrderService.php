<?php

namespace App\Services;


use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder($data)
    {
        DB::beginTransaction();

        try {
            // Get authenticated customer ID
            $customer = auth()->guard('api_customer')->user();
            $customer_id = $customer->id;

            // Create the order
            $order = Order::create([
                'customer_id' => $customer_id, // Customer ID
                'shipping_address_id' => $data['shipping_address_id'],
                'shipping_time_preferred' => $data['shipping_time_preferred'],
                'delivery_status' => 'pending', // Initial order status
                'payment_type' => $data['payment_type'], // Payment type (e.g., Credit Card, PayPal)
                'payment_status' => 'pending', // Payment status (e.g., Pending, Completed)
                'order_notes' => $data['order_notes'] ?? null, // Optional order notes
                'order_amount' => $data['total_amount'], // Total order amount
                'coupon_code' => $data['coupon_code'] ?? null,
                'coupon_title' => $data['coupon_title'] ?? null,
                'coupon_disc_amt_admin' => $data['coupon_disc_amt_admin'] ?? 0, // Admin coupon discount
                'coupon_disc_amt_store' => $data['coupon_disc_amt_store'] ?? 0, // Store coupon discount
                'product_disc_amt' => $data['product_disc_amt'] ?? 0, // Product discount
                'flash_disc_amt_admin' => $data['flash_disc_amt_admin'] ?? 0, // Admin flash sale discount
                'flash_disc_amt_store' => $data['flash_disc_amt_store'] ?? 0, // Store flash sale discount
                'shipping_charge' => $data['shipping_charge'] ?? 0, // Shipping charge
                'additional_charge' => $data['additional_charge'] ?? 0, // Additional charge (if any)
                'confirmed_at' => null,
                'cancel_request_at' => null,
                'cancelled_at' => null,
                'delivery_completed_at' => null,
                'refund_status' => null,
            ]);

            // Add order items (products in the order)
            foreach ($data['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // Rethrow exception for proper error handling
        }
    }

    public function updateOrderStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $status;
        $order->save();
        return $order;
    }

    public function getOrderDetails($orderId)
    {
        $order = Order::with(['orderItems', 'sellerStore'])->findOrFail($orderId);
        return $order;
    }

}
