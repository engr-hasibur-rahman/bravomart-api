<?php

namespace App\Services;


use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderPackage;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\ProductVariant;
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

            // create order payment info
            OrderPayment::create([
                'order_id' => $order->id,
                'payment_gateway' => $data['payment_gateway'],
                'payment_status' => 'pending',
                'paid_amount' => $order->order_amount,
            ]);

            //  packages and details
            foreach ($data['packages'] as $packageData) {
                // Calculate discount to the store  (Store specific coupon discount)
                $order_amount_for_store = calculateStoreShareWithDiscount($packageData['order_amount'], $total_order_amount, $total_discount_amount);
                // create order package
                $package = OrderPackage::create([
                    'order_id' => $order->id,
                    'store_id' => $packageData['store_id'],
                    'order_type' => $packageData['order_type'],
                    'delivery_type' => $packageData['delivery_type'],
                    'shipping_type' => $packageData['shipping_type'],
                    'order_amount' =>  $order_amount_for_store > 0 ? $order_amount_for_store : $packageData['order_amount'], // Use the store-specific order amount or fall back to the original
                    'coupon_disc_amt_admin' => $order_amount_for_store,  // Store specific coupon discount
                    'product_disc_amt' => $packageData['product_disc_amt'],
                    'flash_disc_amt_admin' => $packageData['flash_disc_amt_admin'],
                    'flash_disc_amt_store' => $packageData['flash_disc_amt_store'],
                    'shipping_charge' => $packageData['shipping_charge'],
                    'additional_charge' => $packageData['additional_charge'],
                    'is_reviewed' => false,
                    'status' => 'pending',
                ]);

                foreach ($packageData['items'] as $itemData) {
                    // find the product
                   $product = Product::with('variants')->find($itemData['product_id']);

                    // Validate product variant
                    $variant = $product->variants;
                    $basePrice = $variant->price;
                    $specialPrice = $variant->special_price ?: $basePrice;

                   if (!empty($product) && !empty($variant)) {
                       // store discount calculate
                       $storeDiscount = ($itemData['store_discount_type'] === 'percentage')
                           ? ($specialPrice * $itemData['store_discount_rate'] / 100)
                           : $itemData['store_discount_amount'];
                       // admin discount calculate
                       $adminDiscount = ($itemData['admin_discount_type'] === 'percentage')
                           ? ($specialPrice * $itemData['admin_discount_rate'] / 100)
                           : $itemData['admin_discount_amount'];

                       // Calculate final price
                       $finalPrice = $specialPrice - $storeDiscount - $adminDiscount;


                       // Calculate tax
                       $taxPercent = $itemData['tax_percent'];
                       $taxAmount = $finalPrice * ($taxPercent / 100);

                       // Validate line total
                       $lineTotal = round(($finalPrice + $taxAmount) * $itemData['quantity'], 2);
                       if (round(abs($itemData['line_total_price'] - $lineTotal), 2) > 0.01) {
//                           throw new \Exception("Line total mismatch for variant ID: {$itemData['variant_details']['variant_id']}");
                       }


                       // create order details
                       OrderDetail::create([
                           'order_id' => $order->id,
                           'order_package_id' => $package->id,
                           'product_id' => $product->id,
                           'product_sku' => $product->product_sku,
                           'variant_details' => json_encode($itemData['variant_details']),
                           'product_campaign_id' => $itemData['product_campaign_id'],
                           'base_price' =>  $basePrice,
                           'store_discount_type' => $itemData['store_discount_type'],
                           'store_discount_rate' => $itemData['store_discount_rate'],
                           'store_discount_amount' => $storeDiscount, // store discount amount
                           'admin_discount_type' => $itemData['admin_discount_type'],
                           'admin_discount_rate' => $itemData['admin_discount_rate'],
                           'admin_discount_amount' => $adminDiscount, // admin discount amount
                           'price' => $finalPrice,
                           'quantity' => $itemData['quantity'],
                           'tax_percent' => $itemData['tax_percent'],
                           'tax_amount' => $taxAmount,
                           'line_total_price' => $lineTotal
                       ]);
                   }

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
