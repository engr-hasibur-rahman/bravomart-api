<?php

namespace App\Services;


use App\Models\Area;
use App\Models\ComArea;
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
                    // find area
                    $area = ComArea::find($packageData['area_id']);
                    // find the product
                   $product = Product::with('variants','store', 'flashSaleProduct', 'flashSale')->find($itemData['product_id']);
                    // Validate product variant
                    $variant = ProductVariant::where('id', $itemData['variant_details']['variant_id'])->where('product_id', $product->id)->first();
                    $basePrice = $variant->price;

                   if (!empty($product) && !empty($variant)) {
                       // product flash sale info
                       $product_flash_sale_id = null;
                       $flash_sale_discount_type = null;
                       $flash_sale_discount_amount = 0;
                       $flash_sale_product_creator_type = null;
                       $product_flash_sale_discount_rate = 0;

                       if (!empty($product->flashSale) && isset($product->flashSale->discount_amount)){
                           $product_flash_sale_id = $product->flashSale?->id;
                           $flash_sale_discount_type = $product->flashSale->discount_type;
                           $flash_sale_discount_amount = $product->flashSale->discount_amount;
                           $product_flash_sale_discount_rate = $product->flashSale->discount_amount;
                           if (is_null($flash_sale_discount_amount)){
                               $flash_sale_discount_amount = 0;
                           }
                       };

                       // flash sale product info
                       if (!empty($product->flashSaleProduct)){
                           $flash_sale_product_creator_type = $product->flashSaleProduct?->creator_type;
                       };

                       // store and admin discount calculate per product wise
                       // $flash_sale_store_discount = ($flash_sale_discount_type === 'percentage') ? ($basePrice * $flash_sale_discount_amount / 100) : $flash_sale_discount_amount;
                       $flash_sale_admin_discount = ($flash_sale_discount_type === 'percentage') ? ($basePrice * $flash_sale_discount_amount / 100) : $flash_sale_discount_amount;


                       // Calculate final price
                       $finalPrice = $basePrice - $flash_sale_admin_discount;

                       // get system commission & calculate Tax amount start
                       $system_commission = SystemCommission::latest()->first();

                       // system commission calculate
                       $system_commission_type = null;
                       $system_commission_amount = 0;

                       if (isset($system_commission) && $system_commission->commission_enabled === true) {
                           $system_commission_type = $system_commission->commission_type;
                           $system_commission_amount = $system_commission->commission_amount;
                       }

                       // check store type
                       if ($product->store){
                          $store_subscription_type = $product->store?->subscription_type;
                          // if store commission type commission
                           if($store_subscription_type  === 'commission'){

                           }
                       }

                       // vat/tax calculate
                       $store_tax_amount = $product->store?->tax;
                       $taxAmount = $finalPrice * ($store_tax_amount / 100);

                       // final line total price
                       $line_total_price = round(($finalPrice + $taxAmount) * $itemData['quantity'], 2);

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

                           // store discount
                           'store_discount_type' => null,
                           'store_discount_rate' => 0,
                           'store_discount_amount' => 0,

                           // admin discount amount
                           'admin_discount_type' => $flash_sale_discount_type,
                           'admin_discount_rate' => $product_flash_sale_discount_rate,
                           'admin_discount_amount' => $flash_sale_admin_discount,

                           'base_price' =>  $basePrice,
                           'price' => $finalPrice,
                           'quantity' => $itemData['quantity'],
                           'tax_percent' => $itemData['tax_percent'],
                           'tax_amount' => $taxAmount,
                           'line_total_price' => $line_total_price
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
