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
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\SystemCommission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Subscription\app\Models\StoreSubscription;

class ooooooOrderService
{
    public function createOrder($data)
    {

        DB::beginTransaction();

//        try {


        $customer = auth()->guard('api_customer')->user();

        // guest registration/login
        $token_login = null;
        $customer_info = null;

        if (!$customer && isset($data['guest_info']['guest_order']) && $data['guest_info']['guest_order'] === true) {
            $guestData = $data['guest_info'];
            // Check if email already exists
            $customer = Customer::where('email', $guestData['email'])->first();
            $fullName = trim($guestData['name']);
            $nameParts = preg_split('/\s+/', $fullName, -1, PREG_SPLIT_NO_EMPTY);
            $firstName = $nameParts[0] ?? ''; // First word as first name
            $lastName = isset($nameParts[1]) ? implode(' ', array_slice($nameParts, 1)) : '';
            if (!$customer) {
                $customer = Customer::create([
                    'first_name' => $firstName,
                    'last_name'  => $lastName,
                    'email' => $guestData['email'],
                    'phone' => $guestData['phone'],
                    'password' => Hash::make($guestData['password']),
                ]);
                // Commit the transaction
                DB::commit();

                $token_login = $customer->createToken('customer_auth_token')->plainTextToken;
                // Log in the new customer
                auth()->guard('api_customer')->login($customer);
            }
        }

        // If customer is still null after guest login
            if (!$customer) {
                return false;
            }

            // Check if the user is authenticated
            if (!auth('api_customer')->check()) {
                return false;
            }


            // Get authenticated customer ID
            $customer = auth()->guard('api_customer')->user();
            $customer_id = $customer->id;

            // create order master
        $order_master = OrderMaster::create([
                'customer_id' => $customer_id,
                'area_id' => 0, // main zone id
                'shipping_address_id' => $data['shipping_address_id'],
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


            // system commission
            $system_commission = SystemCommission::latest()->first();
            // shipping charge calculate
            $order_shipping_charge = $system_commission->order_shipping_charge;
            //  packages and details
            $shipping_charge = 0;

            foreach ($data['packages'] as $packageData) {
                // find store wise area id
                $store_info = Store::find($packageData['store_id']);
                // create order main order package wise
                $package = Order::create([
                    'order_master_id' => $order_master->id,
                    'store_id' => $packageData['store_id'],
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

            return [
                $all_orders,
                $order_master,
                'customer' => $customer_info,
                'token' => $token_login,
            ];
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
