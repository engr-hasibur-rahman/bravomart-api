<?php

namespace Modules\Subscription\app\Services;

use App\Models\ComMerchantStore;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Subscription\app\Models\ComMerchantStoresSubscription;
use Modules\Subscription\app\Models\Subscription;
use Modules\Subscription\app\Models\SubscriptionHistory;


class SubscriptionService
{
    public function buySubscriptionPackage($store, $data)
    {
        // Authenticate user
        $seller = Auth::guard('api')->user();
        if (!$seller) {
            return [
                'success' => false,
                'message' => 'User is not authenticated.',
            ];
        }

        if(isset($store->subscription_type) && $store->subscription_type === 'subscription'){
            // subscription package
            $subscription_package = Subscription::where('id', $data['subscription_id'])
                ->where('status', 1)
                ->first();

            // if package not found
            if (empty($subscription_package)){
                return [
                    'success' => false,
                    'message' => "Subscription package not found",
                ];
            }

            $store_id = $store->id;

            // if seller store payment using wallet
            $payment_gateway = $data['payment_gateway'];
            if(isset($payment_gateway) && $payment_gateway == 'wallet'){
                // find store and update store status
                $store = ComMerchantStore::find($store_id);
                $store->status = 1;
                $store->save();
                // subscription status set
                $subscription_status = 1;
                $payment_status = 'paid';
            }else{
                $subscription_status = 0;
                $payment_status = 'pending';
            }


            // Create subscription history
            SubscriptionHistory::create([
                'store_id' => $store_id,
                'subscription_id' => $subscription_package->id,
                'name' => $subscription_package->name,
                'validity' => $subscription_package->validity,
                'price' => $subscription_package->price,
                'pos_system' => $subscription_package->pos_system,
                'self_delivery' => $subscription_package->self_delivery,
                'mobile_app' => $subscription_package->mobile_app,
                'live_chat' => $subscription_package->live_chat,
                'order_limit' => $subscription_package->order_limit,
                'product_limit' => $subscription_package->product_limit,
                'product_featured_limit' => $subscription_package->product_featured_limit,
                'payment_gateway' =>$payment_gateway ?? null,
                'payment_status' => $payment_status ?? null,
                'transaction_id' => $data['transaction_id'] ?? null,
                'manual_image' => $data['manual_image'] ?? null,
                'expire_date' => now()->addDays($subscription_package->validity),
                'status' => $subscription_status,
            ]);

            // Create store wise subscription
            ComMerchantStoresSubscription::create([
                'store_id' => $store_id,
                'subscription_id' => $subscription_package->id,
                'name' => $subscription_package->name,
                'validity' => $subscription_package->validity,
                'price' => $subscription_package->price,
                'pos_system' => $subscription_package->pos_system,
                'self_delivery' => $subscription_package->self_delivery,
                'mobile_app' => $subscription_package->mobile_app,
                'live_chat' => $subscription_package->live_chat,
                'order_limit' => $subscription_package->order_limit,
                'product_limit' => $subscription_package->product_limit,
                'product_featured_limit' => $subscription_package->product_featured_limit,
                'payment_gateway' => $payment_gateway ?? null,
                'payment_status' => $payment_status ?? null,
                'transaction_id' => $data['transaction_id'] ?? null,
                'manual_image' => $data['manual_image'] ?? null,
                'expire_date' => now()->addDays($subscription_package->validity),
                'status' => $subscription_status,
            ]);
        }else{
            return [
                'success' => false,
                'message' => "Subscription type not found",
            ];
        }
    }

    public function renewSubscriptionPackage($store, $data)
    {
        // Authenticate user
        $seller = Auth::guard('api')->user();
        if (!$seller) {
            return [
                'success' => false,
                'message' => 'User is not authenticated.',
            ];
        }

        if (isset($store->subscription_type) && $store->subscription_type === 'subscription') {
            // Find active subscription for the store
            $currentSubscription = ComMerchantStoresSubscription::where('store_id', $store->id)->first();

            // Check if there is an active subscription
            if (!$currentSubscription) {
                return [
                    'success' => false,
                    'message' => 'No active subscription found for the store.',
                ];
            }

            // Fetch the subscription package
            $subscriptionPackage = Subscription::where('id', $data['subscription_id'])
                ->where('status', 1)
                ->first();

            if (!$subscriptionPackage) {
                return [
                    'success' => false,
                    'message' => 'Subscription package not found.',
                ];
            }

            $store_id = $store->id;

            // Determine payment gateway
            $payment_gateway = $data['payment_gateway'];
            if (isset($payment_gateway) && $payment_gateway === 'wallet') {
                $subscription_status = 1;
                $payment_status = 'paid';
            } else {
                $subscription_status = 0;
                $payment_status = 'pending';
            }

            // Calculate the new expiration date
            $newExpireDate = Carbon::parse($currentSubscription->expire_date)->gt(now())
                ? Carbon::parse($currentSubscription->expire_date)->addDays($subscriptionPackage->validity)
                : now()->addDays($subscriptionPackage->validity);

            // Create subscription history
            SubscriptionHistory::create([
                'store_id' => $store_id,
                'subscription_id' => $subscriptionPackage->id,
                'name' => $subscriptionPackage->name,
                'validity' => $subscriptionPackage->validity,
                'price' => $subscriptionPackage->price,
                'pos_system' => $subscriptionPackage->pos_system,
                'self_delivery' => $subscriptionPackage->self_delivery,
                'mobile_app' => $subscriptionPackage->mobile_app,
                'live_chat' => $subscriptionPackage->live_chat,
                'order_limit' => $subscriptionPackage->order_limit,
                'product_limit' => $subscriptionPackage->product_limit,
                'product_featured_limit' => $subscriptionPackage->product_featured_limit,
                'payment_gateway' => $payment_gateway ?? null,
                'payment_status' => $payment_status ?? null,
                'transaction_id' => $data['transaction_id'] ?? null,
                'manual_image' => $data['manual_image'] ?? null,
                'expire_date' => $newExpireDate,
                'status' => $subscription_status,
            ]);

            // Update or create store subscription
            $currentSubscription->updateOrCreate(
                ['store_id' => $store_id],
                [
                    'subscription_id' => $subscriptionPackage->id,
                    'name' => $subscriptionPackage->name,
                    'validity' => $subscriptionPackage->validity,
                    'price' => $subscriptionPackage->price,
                    'pos_system' => $subscriptionPackage->pos_system,
                    'self_delivery' => $subscriptionPackage->self_delivery,
                    'mobile_app' => $subscriptionPackage->mobile_app,
                    'live_chat' => $subscriptionPackage->live_chat,
                    'order_limit' => $subscriptionPackage->order_limit,
                    'product_limit' => $subscriptionPackage->product_limit,
                    'product_featured_limit' => $subscriptionPackage->product_featured_limit,
                    'payment_gateway' => $payment_gateway ?? null,
                    'payment_status' => $payment_status ?? null,
                    'transaction_id' => $data['transaction_id'] ?? null,
                    'manual_image' => $data['manual_image'] ?? null,
                    'expire_date' => $newExpireDate,
                    'status' => $subscription_status,
                ]
            );

            return [
                'success' => true,
                'message' => 'Subscription renewed successfully.',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Subscription type not found.',
            ];
        }

    }

}
