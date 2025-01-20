<?php

namespace App\Services;


use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderPackage;
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
                'customer_id' => $customer_id,
                'shipping_address_id' => $data['shipping_address_id'],
                'shipping_time_preferred' => $data['shipping_time_preferred'],
                'delivery_status' => 'pending',
                'payment_type' => $data['payment_type'],
                'payment_status' => 'pending',
                'order_notes' => $data['order_notes'] ?? null,
                'order_amount' => $data['order_amount'],
                'coupon_code' => $data['coupon_code'] ?? null,
                'coupon_title' => $data['coupon_title'] ?? null,
                'coupon_disc_amt_admin' => $data['coupon_disc_amt_admin'] ?? 0,
                'coupon_disc_amt_store' => $data['coupon_disc_amt_store'] ?? 0,
                'product_disc_amt' => $data['product_disc_amt'] ?? 0,
                'flash_disc_amt_admin' => $data['flash_disc_amt_admin'] ?? 0,
                'flash_disc_amt_store' => $data['flash_disc_amt_store'] ?? 0,
                'shipping_charge' => $data['shipping_charge'] ?? 0,
                'additional_charge' => $data['additional_charge'] ?? 0,
                'confirmed_at' => null,
                'cancel_request_at' => null,
                'cancelled_at' => null,
                'delivery_completed_at' => null,
                'refund_status' => null,
            ]);

            // order package and details
            foreach ($data['packages'] as $packageData) {
                // create order package
                $package = OrderPackage::create([
                    'order_id' => $order->id,
                    'store_id' => $packageData['store_id'],
                    'order_amount' => $packageData['order_amount'],
                ]);

                foreach ($packageData['items'] as $itemData) {
                    // create order details
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'package_id' => $package->id,
                        'product_id' => $itemData['product_id'],
                        'rate' => $itemData['rate'],
                        'quantity' => $itemData['quantity'],
                        'line_total' => $itemData['line_total'],
                    ]);
                }
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
