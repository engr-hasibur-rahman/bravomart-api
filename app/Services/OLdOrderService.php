<?php

namespace App\Services;


use App\Models\Area;
use App\Models\StoreArea;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderPackage;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\SystemCommission;
use Illuminate\Support\Facades\DB;

class OLdOrderService
{
    public function createOrder($data)
    {

        DB::beginTransaction();

//        try {
            // Get authenticated customer ID
            $customer = auth()->guard('api_customer')->user();
            $customer_id = $customer->id;

           // Initialize total order amount
           $calculate_total_order_amount = 0;
            foreach ($data['packages'] as $packageData) {
                foreach ($packageData['items'] as $itemData) {
                    // find the product
                    $product = Product::with('variants', 'store', 'flashSaleProduct', 'flashSale')->find($itemData['product_id']);
                    // Validate product variant
                    $variant = ProductVariant::where('id', $itemData['variant_details']['variant_id'])->where('product_id', $product->id)->first();
                    $basePrice = $variant->price;
                    // Add to total order amount
                    $calculate_total_order_amount += $basePrice;
                }
            }

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
                'coupon_discount_amount_admin' => $total_discount_amount ?? 0, // total discount amount

                'product_discount_amount' => $data['product_discount_amount'] ?? 0,
                'flash_discount_amount_admin' => $data['flash_discount_amount_admin'] ?? 0,
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


               $calculate_total_order_amount_base_price = 0; // To accumulate the total price
              $main_order_amount_after_discount = 0; // To accumulate the total price
                // this calculations only for main order base price calculate
                foreach ($data['packages'] as $packageData) {
                    foreach ($packageData['items'] as $itemData) {
                        // find the product
                        $product = Product::with('variants','store', 'flashSaleProduct', 'flashSale')->find($itemData['product_id']);
                        // Validate product variant
                        $variant = ProductVariant::where('id', $itemData['variant_details']['variant_id'])->where('product_id', $product->id)->first();
                        $basePrice = $variant->price;

                        if (!empty($product) && !empty($variant)) {
                            // product flash sale info
                            $product_flash_sale_id = null;
                            $flash_sale_discount_type = null;
                            $flash_sale_discount_amount = 0.00;
                            $flash_sale_product_creator_type = null;
                            $product_flash_sale_discount_rate = 0.00;

                            if (!empty($product->flashSale) && isset($product->flashSale->discount_amount)){
                                $product_flash_sale_id = $product->flashSale?->id;
                                $flash_sale_discount_type = $product->flashSale->discount_type;
                                $flash_sale_discount_amount = $product->flashSale->discount_amount;
                                $product_flash_sale_discount_rate = $product->flashSale->discount_amount;

                                // Check if the flash sale has expired
                                $flash_sale_start_time = $product->flashSale->start_time;
                                $flash_sale_end_time = $product->flashSale->end_time;

                                // Check if current time is within the flash sale period
                                $current_time = now(); // Get the current time
                                $is_expired = $current_time->gt($flash_sale_end_time); // Check if current time is greater than the end time

                                if ($is_expired) {
                                    // Flash sale has expired
                                    $product_flash_sale_id = null;
                                    $flash_sale_discount_type = null;
                                    $flash_sale_discount_amount = 0;
                                    $product_flash_sale_discount_rate = 0;
                                }
                            };

                            // store and admin discount calculate per product wise
                            $flash_sale_admin_discount = ($flash_sale_discount_type === 'percentage') ? ($basePrice * $flash_sale_discount_amount / 100.00) : $flash_sale_discount_amount;
                            $finalPrice = $basePrice - $flash_sale_admin_discount;
                            $after_any_discount_final_price = $finalPrice;

                            $calculate_total_order_amount_base_price += $basePrice;
                            $main_order_amount_after_discount += $after_any_discount_final_price;

                        }
                    }
                }


            //  packages and details
            foreach ($data['packages'] as $packageData) {

                // Calculate discount to the store  (Store specific coupon discount)
                $order_amount_for_store = calculateStoreShareWithDiscount($packageData['order_amount'], $total_order_amount, $total_discount_amount);
                // create order package
                $package = OrderPackage::create([
                    'order_id' => $order->id,
                    'store_id' => $packageData['store_id'],

                    'order_type' => 'regular', // if customer order create
                    'delivery_type' => $packageData['delivery_type'],
                    'shipping_type' => $packageData['shipping_type'],

                    'order_amount' =>  $order_amount_for_store > 0 ? $order_amount_for_store : $packageData['order_amount'], // Use the store-specific order amount or fall back to the original
                    'coupon_discount_amount_admin' => $order_amount_for_store,  // Store specific coupon discount
                    'product_discount_amount' => $packageData['product_discount_amount'],
                    'flash_discount_amount_admin' => $packageData['flash_discount_amount_admin'],
                    'flash_disc_amt_store' => $packageData['flash_disc_amt_store'],
                    'shipping_charge' => $packageData['shipping_charge'],
                    'additional_charge' => $packageData['additional_charge'],
                    'is_reviewed' => false,
                    'status' => 'pending',
                ]);

                 // per item calculate
                foreach ($packageData['items'] as $itemData) {
                    // find area
                    $area = StoreArea::find($packageData['area_id']);
                    // find the product
                   $product = Product::with('variants','store', 'flashSaleProduct', 'flashSale')->find($itemData['product_id']);
                    // Validate product variant
                    $variant = ProductVariant::where('id', $itemData['variant_details']['variant_id'])->where('product_id', $product->id)->first();
                    $basePrice = $variant->price;

                   if (!empty($product) && !empty($variant)) {
                       // product flash sale info
                       $product_flash_sale_id = null;
                       $flash_sale_discount_type = null;
                       $flash_sale_discount_amount = 0.00;
                       $flash_sale_product_creator_type = null;
                       $product_flash_sale_discount_rate = 0.00;

                       if (!empty($product->flashSale) && isset($product->flashSale->discount_amount)){
                           $product_flash_sale_id = $product->flashSale?->id;
                           $flash_sale_discount_type = $product->flashSale->discount_type;
                           $flash_sale_discount_amount = $product->flashSale->discount_amount;
                           $product_flash_sale_discount_rate = $product->flashSale->discount_amount;

                           // Check if the flash sale has expired
                           $flash_sale_start_time = $product->flashSale->start_time;
                           $flash_sale_end_time = $product->flashSale->end_time;

                           // Check if current time is within the flash sale period
                           $current_time = now(); // Get the current time
                           $is_expired = $current_time->gt($flash_sale_end_time); // Check if current time is greater than the end time

                           if ($is_expired) {
                               // Flash sale has expired
                               $product_flash_sale_id = null;
                               $flash_sale_discount_type = null;
                               $flash_sale_discount_amount = 0;
                               $product_flash_sale_discount_rate = 0;
                           }
                       };


                       // store and admin discount calculate per product wise
                       // $flash_sale_store_discount = ($flash_sale_discount_type === 'percentage') ? ($basePrice * $flash_sale_discount_amount / 100) : $flash_sale_discount_amount;
                       $flash_sale_admin_discount = ($flash_sale_discount_type === 'percentage') ? ($basePrice * $flash_sale_discount_amount / 100.00) : $flash_sale_discount_amount;


                       // Calculate final price
                       $finalPrice = $basePrice - $flash_sale_admin_discount;

                       // after flash sale discount
                       $after_flash_sale_discount_final_price = $finalPrice;

                       // **Calculate Coupon Discount Per Item**
                       if (isset($coupon_data['discount_amount'])) {
                           $coupon_discount_type = $coupon_data['coupon_type'];
                           $coupon_discount_rate = $coupon_data['discount_rate'];
                           $coupon_discount_amount= $coupon_data['discount_amount'];

                           if ($coupon_discount_type === 'percentage') {
                               // Percentage-based discount - distribute
                               $per_item_coupon_discount_amount = round($after_flash_sale_discount_final_price * ($coupon_discount_rate / 100), 2);
                           } elseif ($coupon_discount_type === 'fixed') {
                               // Fixed amount discount - distribute
                               $item_contribution_ratio = $after_flash_sale_discount_final_price / $main_order_amount_after_discount;
                               $per_item_coupon_discount_amount = round($item_contribution_ratio * $coupon_discount_amount, 2);

                           }else {
                               $per_item_coupon_discount_amount = 0;
                           }
                       }


                       // Calculate final price after all discounts (flash sale + coupon)
                       $after_any_discount_final_price = $after_flash_sale_discount_final_price;

                       // total quantity and after flash discount
                       $after_discount_final_price_with_qty =  $after_any_discount_final_price * $itemData['quantity'];

                       // without tax line total price  and - coupon total discount
                       $line_total_excluding_tax =  $after_discount_final_price_with_qty - $per_item_coupon_discount_amount;

                       // vat/tax calculate
                       $store_tax_amount = $product->store?->tax;
                       $taxAmount = $after_any_discount_final_price * ($store_tax_amount / 100.00);

                       // Total tax amount based on quantity
                       $total_tax_amount = $taxAmount * $itemData['quantity'];

                       // Final line total price based on quantity
                       $line_total_price = $line_total_excluding_tax + $total_tax_amount;


                       // Get system commission
                       $system_commission = SystemCommission::latest()->first();
                       // Initialize commission variables
                       $system_commission_type = null;
                       $system_commission_amount = 0.00;
                       $admin_commission_amount = 0.00;
                       // calculate commission
                       if (isset($system_commission) && $system_commission->commission_enabled === true) {
                           // Check store type
                           if ($product->store) {
                               $store_subscription_type = $product->store?->subscription_type;
                               // If store is commission-based
                               if ($store_subscription_type === 'commission') {
                                   $system_commission_type = $system_commission->commission_type;
                                   $system_commission_amount = $system_commission->commission_amount;

                                   // Calculate admin commission based on type
                                   if ($system_commission_type === 'percentage') {
                                       $admin_commission_amount = ($line_total_excluding_tax * $system_commission_amount) / 100.00;
                                   } elseif ($system_commission_type === 'fixed') {
                                       $admin_commission_amount = $system_commission_amount;
                                   }
                               }
                           }
                       }


                       // create order details
                       OrderDetail::create([
                           'store_id' => $product->store?->id,
                           'area_id' => $area->id,
                           'order_id' => $order->id,
                           'order_package_id' => $package->id,
                           'product_id' => $product->id,
                           'product_sku' => $variant->sku,
                           'behaviour' => $product->behaviour,

                           'variant_details' => $variant->attributes,
                           'product_campaign_id' => $product_flash_sale_id,

                           // admin discount amount
                           'admin_discount_type' => $flash_sale_discount_type,
                           'admin_discount_rate' => $product_flash_sale_discount_rate,
                           'admin_discount_amount' => $flash_sale_admin_discount,

                           // coupon discount amount
                           'coupon_discount_amount' => $per_item_coupon_discount_amount,

                           // price and qty
                           'base_price' =>  $basePrice,
                           'price' => $after_any_discount_final_price,
                           'quantity' => $itemData['quantity'],
                           'line_total_price_with_qty' => $after_discount_final_price_with_qty,
                           'line_total_excluding_tax' => $line_total_excluding_tax, // Total without tax
                           'tax_rate' => $store_tax_amount,
                           'tax_amount' => $taxAmount,
                           'total_tax_amount' => $total_tax_amount,
                           'line_total_price' => $line_total_price,

                           // admin commission
                           'admin_commission_type' => $system_commission_type,
                           'admin_commission_rate' => $system_commission_amount,
                           'admin_commission_amount' => $admin_commission_amount,
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
