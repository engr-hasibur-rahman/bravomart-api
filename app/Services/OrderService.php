<?php

namespace App\Services;


use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderPackage;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder($data)
    {

        DB::beginTransaction();

//        try {
            // Get authenticated customer ID
            $customer = auth()->guard('api_customer')->user();
            $customer_id = $customer->id;

            // Coupon Apply
            $total_order_amount =  $data['order_amount'] ?? 0;
            $total_discount_amount = $data['discount_amount'] ?? 0;

            // calculate order coupon
            if(isset($data['coupon_code'])){
                $coupon_data = applyCoupon($data['coupon_code'], $data['order_amount']);
                if (isset($coupon_data['final_order_amount'])){
                    $total_order_amount = $coupon_data['final_order_amount'];
                    $total_discount_amount = $coupon_data['discount_amount'];
                }
            }


            // Create the order
            $order = Order::create([
                'customer_id' => $customer_id,
                'shipping_address_id' => $data['shipping_address_id'],
                'payment_gateway' => $data['payment_gateway'],
                'payment_status' => 'pending',
                'order_notes' => $data['order_notes'] ?? null,
                'order_amount' => $total_order_amount, // total order amount

                'coupon_code' => $data['coupon_code'] ?? null,
                'coupon_title' => $data['coupon_title'] ?? null,
                'coupon_disc_amt_admin' => $total_discount_amount ?? 0, // total discount amount

                'product_disc_amt' => $data['product_disc_amt'] ?? 0,
                'flash_disc_amt_admin' => $data['flash_disc_amt_admin'] ?? 0,
                'flash_disc_amt_store' => $data['flash_disc_amt_store'] ?? 0,
                'shipping_charge' => $data['shipping_charge'] ?? 0,
                'additional_charge_title' => $data['additional_charge_title'] ?? null,
                'additional_charge_amt' => $data['additional_charge_amt'] ?? 0,
                'confirmed_by' => null,
                'confirmed_at' => null,
                'cancel_request_by' => null,
                'cancel_request_at' => null,
                'cancelled_by' => null,
                'cancelled_at' => null,
                'delivery_completed_at' => null,
                'refund_status' => null,
                'status' => 'pending',
            ]);

            //  packages and details
            foreach ($data['order_packages'] as $packageData) {
                // Calculate discount to the store  (Store specific coupon discount)
                $order_amount_for_store = calculateStoreShareWithDiscount($packageData['order_amount'], $total_order_amount, $total_discount_amount);

                // create order package
                $package = OrderPackage::create([
                    'order_id' => $order->id,
                    'store_id' => $packageData['store_id'],
                    'order_type' => $packageData['order_type'],
                    'delivery_type' => $packageData['delivery_type'],
                    'shipping_type' => $packageData['shipping_type'],
                    'order_amount' => $packageData['order_amount'],
                    'coupon_disc_amt_admin' => $order_amount_for_store,  // Store specific coupon discount
                ]);

                foreach ($packageData['order_details'] as $itemData) {
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
//        } catch (\Exception $e) {
//            DB::rollBack();
//            throw $e; // Rethrow exception for proper error handling
//        }
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
