<?php

namespace App\Services;


use App\Helpers\DeliveryChargeHelper;
use App\Models\Area;
use App\Models\Store;
use App\Models\StoreArea;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderMaster;
use App\Models\OrderPayment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\SystemCommission;
use Illuminate\Support\Facades\DB;
use Modules\Subscription\app\Models\StoreSubscription;

class OrderService
{
    public function createOrder($data)
    {

        DB::beginTransaction();

//        try {
            // Get authenticated customer ID
            $customer = auth()->guard('api_customer')->user();
            $customer_id = $customer->id;

            // calculate  base price
            $basePrice = 0;
            foreach ($data['packages'] as $packageData) {

                 // if type subscription
                 $store = Store::find($packageData['store_id']);
                // subscription check start
                if ($store->subscription_type === 'subscription'){
                    // check store subscription package
                    $store_subscription = StoreSubscription::where('store_id', $store->id)
                        ->whereDate('expire_date', '>=', now())
                        ->first();
                    // if expire subscription
                    if (empty($store_subscription)){
                        return false;
                    }
                    //  condition
                    $total_store_order = Order::whereNotIn('status', ['pending', 'cancelled', 'on_hold'])->count();
                    // check order limit
                    if (!empty($store_subscription) && $store_subscription->order_limit <= $total_store_order) {
                        return false;
                     }
                 } // subscription check end


                foreach ($packageData['items'] as $itemData) {
                    // find the product
                    $product = Product::with('variants', 'store', 'flashSaleProduct', 'flashSale')->find($itemData['product_id']);
                    // Validate product variant
                    $variant = ProductVariant::where('id', $itemData['variant_id'])->where('product_id', $product->id)->first();
                    // Add to total order amount
                    if (!empty($variant) && isset($variant->price)) {
                        $basePrice += ($variant->special_price > 0) ? $variant->special_price : $variant->price;
                    }
                }
            }


        // calculate order coupon
            if(isset($data['coupon_code'])){
                $coupon_data = applyCoupon($data['coupon_code'], $basePrice);
                if (isset($coupon_data['final_order_amount'])){
                    $total_order_amount = $coupon_data['final_order_amount'];
                    $total_discount_amount = $coupon_data['discount_amount'];
                }
            }else{
                $coupon_data = [
                    'success' => false,
                    'coupon_code' => null,
                    'coupon_title' => null,
                ];
            }


            // create order master
        $order_master = OrderMaster::create([
                'customer_id' => $customer_id,
                'area_id' => 0, // main zone id
                'shipping_address_id' => $data['shipping_address_id'],
                'coupon_code' => $coupon_data['success'] === false ? null : $data['coupon_code'] ?? null,
                'coupon_title' => $coupon_data['success'] === false ? null : $data['coupon_title'] ?? null,
                'coupon_discount_amount_admin' => 0,
                'product_discount_amount' => 0,
                'flash_discount_amount_admin' => 0,
                'shipping_charge' => 0,
                'additional_charge_name' => null,
                'additional_charge_amount' => 0,
                'additional_charge_commission' => 0,
                'order_amount' => 0,
                'paid_amount' => 0,
                'payment_gateway' => $data['payment_gateway'],
                'payment_status' => 'pending',
                'order_notes' => $data['order_notes'] ?? null,
            ]);



               $calculate_total_order_amount_base_price = 0; // To accumulate the total price
              $main_order_amount_after_discount = 0; // To accumulate the total price
                // this calculations only for main order base price calculate
                foreach ($data['packages'] as $packageData) {
                    foreach ($packageData['items'] as $itemData) {

                        // find the product
                        $product = Product::with('variants','store', 'flashSaleProduct', 'flashSale')->find($itemData['product_id']);
                        // Validate product variant
                        $variant = ProductVariant::where('id',$itemData['variant_id'])->where('product_id', $product->id)->first();
                        if (!empty($variant) && isset($variant->price)) {
                            $basePrice = ($variant->special_price > 0) ? $variant->special_price : $variant->price;
                        }

                        if (!empty($product) && !empty($variant)) {
                            // product flash sale info
                            $product_flash_sale_id = null;
                            $flash_sale_discount_type = null;
                            $flash_sale_discount_amount = 0.00;
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


            // system commission
            $system_commission = SystemCommission::latest()->first();
            // shipping charge calculate
            $order_shipping_charge = $system_commission->order_shipping_charge;

            //  packages and details
            $shipping_charge = 0;
            $customer_lat = $data['customer_latitude'] ?? null;
            $customer_lng = $data['customer_longitude'] ?? null;

            foreach ($data['packages'] as $packageData) {

                // find store wise area id
                $store_info = Store::find($packageData['store_id']);
                $store_area_id = $store_info->area_id;

                // area wise calculate delivery charge
                $deliveryChargeData = DeliveryChargeHelper::calculateDeliveryCharge($store_area_id, $customer_lat, $customer_lng);

                // Ensure delivery charge data is an array to avoid errors
                if (!is_array($deliveryChargeData)) {
                    $deliveryChargeData = ['delivery_charge' => null];
                }

                // Get the delivery charge or default to 0
                $final_shipping_charge = $deliveryChargeData['delivery_charge'] ?? 0;


                // If area-wise delivery charge is 0 or not set, use the default order shipping charge
                if (empty($deliveryChargeData['delivery_charge']) || $deliveryChargeData['delivery_charge'] == 0) {
                    $final_shipping_charge = $order_shipping_charge;
                }

                // create order main order package wise
                $package = Order::create([
                    'order_master_id' => $order_master->id,
                    'store_id' => $packageData['store_id'],
                    'area_id' => $store_area_id,
                    'order_type' => 'regular', // if customer order create
                    'delivery_type' => $packageData['delivery_type'],
                    'delivery_option' => $packageData['delivery_option'],
                    'delivery_time' => $packageData['delivery_time'],
                    'order_amount' => 0,
                    'coupon_discount_amount_admin' => 0,
                    'product_discount_amount' => 0,
                    'flash_discount_amount_admin' => 0,
                    'shipping_charge' => $final_shipping_charge,
                    'is_reviewed' => false,
                    'status' => 'pending',
                ]);


                // set order package discount info
                $order_package_total_amount = 0;
                $product_discount_amount = 0;
                $flash_discount_amount_admin = 0;
                $coupon_discount_amount_admin = 0;
                $package_order_amount_store_value = 0;
                $package_order_amount_admin_commission = 0;

                 // per item calculate
                foreach ($packageData['items'] as $itemData) {
                    // find the product
                    $product = Product::with('variants','store', 'flashSaleProduct', 'flashSale')->find($itemData['product_id']);
                    // Validate product variant
                    $variant = ProductVariant::where('id', $itemData['variant_id'])->where('product_id', $product->id)->first();
                    if (!empty($variant) && isset($variant->price)) {
                        $basePrice = ($variant->special_price > 0) ? $variant->special_price : $variant->price;
                    }

                    if (!empty($product) && !empty($variant)) {
                       // product flash sale info
                       $product_flash_sale_id = null;
                       $flash_sale_discount_type = null;
                       $flash_sale_discount_amount = 0.00;
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


                       // Calculate final price
                       $finalPrice = $basePrice - $flash_sale_admin_discount;

                       // after flash sale discount
                       $after_flash_sale_discount_final_price = $finalPrice;

                       // **Calculate Coupon Discount Per Item**
                       $per_item_coupon_discount_amount = 0;
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
                        $orderDetails =  OrderDetail::create([
                           'order_id' => $package->id,
                           'store_id' => $product->store?->id,
                           'area_id' => $product->store?->area_id,
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

                       // set order package discount info
                       $order_package_total_amount += $orderDetails->line_total_price;
                       $product_discount_amount += ($variant?->price - $variant?->special_price);
                       $flash_discount_amount_admin += $orderDetails->admin_discount_amount;
                       $coupon_discount_amount_admin += $orderDetails->coupon_discount_amount;

                       // order package update other info
                       $package_order_amount_store_value += $orderDetails->line_total_price - $orderDetails->admin_commission_amount;
                       $package_order_amount_admin_commission += $orderDetails->admin_commission_amount;
                   }

                } // end order details

                // update order package details
                $package->order_amount = $order_package_total_amount; //order package total amount
                $package->product_discount_amount = $product_discount_amount; // product coupon  discount
                $package->flash_discount_amount_admin = $flash_discount_amount_admin;  // flash sale discount
                $package->coupon_discount_amount_admin = $coupon_discount_amount_admin; // admin coupon  discount
                $package->order_amount_store_value = $package_order_amount_store_value; // order_amount_admin_commission
                $package->order_amount_admin_commission = $package_order_amount_admin_commission; // order_amount_admin_commission
                $package->save();


                // Accumulate package values for the main order
                $order_package_total_amount += $order_package_total_amount;
                $product_discount_amount += $product_discount_amount;
                $flash_discount_amount_admin += $flash_discount_amount_admin;
                $coupon_discount_amount_admin += $coupon_discount_amount_admin;
                $shipping_charge += $package->shipping_charge;
            } // end order package



           // main order update all package price wise
            $order_master->product_discount_amount = $product_discount_amount;
            $order_master->flash_discount_amount_admin = $flash_discount_amount_admin;
            $order_master->coupon_discount_amount_admin = $coupon_discount_amount_admin;
            $order_master->shipping_charge = $shipping_charge;
            $order_master->order_amount = $order_package_total_amount;
            $order_master->save();

            DB::commit();

            // return all order id
            $all_orders = Order::where('order_master_id', $order_master->id)->get();
            $order_master = OrderMaster::find($order_master->id);

            return [$all_orders, $order_master];
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
