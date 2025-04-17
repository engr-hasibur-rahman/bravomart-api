<?php

namespace Modules\Subscription\app\Services;

use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Subscription\app\Models\StoreSubscription;
use Modules\Subscription\app\Models\Subscription;
use Modules\Subscription\app\Models\SubscriptionHistory;


class SubscriptionService
{
    public function buySubscriptionPackage($data)
    {

       $store_id = $data['store_id'];
       $subscription_id = $data['subscription_id'];
       $payment_gateway = $data['payment_gateway'];

        // Find the store
        $store = Store::find($store_id);
        if (!$store) {
            return [
                'success' => false,
                'message' => 'Store not found.',
            ];
        }

        // Find the subscription package
        $subscription_package = Subscription::where('id', $subscription_id)
            ->where('status', 1)
            ->first();

        // If package not found
        if (empty($subscription_package)) {
            return [
                'success' => false,
                'message' => 'Subscription package not found.',
            ];
        }

        // Set default values for payment status
        $subscription_status = 0;
        $payment_status = 'pending';

        // Check payment gateway (wallet or others)
        if ($payment_gateway == 'wallet') {
            // Update store status if paid through wallet
            $store->status = 1;
            $store->save();

            $subscription_status = 1;
            $payment_status = 'paid';
        }

        // Check for existing subscription and update if found
        $existing_subscription = StoreSubscription::where('store_id', $store_id)
            ->where('subscription_id', $subscription_package->id)
            ->first();


        if ($existing_subscription) {
            // Calculate new validity based on current expire date
            $new_validity = $subscription_package->validity;

            // Convert the expire_date to a Carbon instance to use addDays()
            $existing_expiry_date = \Carbon\Carbon::parse($existing_subscription->expire_date);

            // Extend the subscription validity by adding the new validity to the current expire date
            $new_expire_date = $existing_expiry_date->addDays($new_validity);

            // Update the existing subscription
            $existing_subscription->type = $subscription_package->type;
            $existing_subscription->expire_date = $new_expire_date;
            $existing_subscription->status = $subscription_status;
            $existing_subscription->payment_status = $payment_status;
            $existing_subscription->payment_gateway = $payment_gateway;
            $existing_subscription->save();

            // Create subscription history
            SubscriptionHistory::create([
                'store_subscription_id' => $existing_subscription->id,
                'store_id' => $store_id,
                'subscription_id' => $subscription_package->id,
                'name' => $subscription_package->name,
                'type' => $subscription_package->type,
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
                'transaction_ref' =>  null,
                'manual_image' =>  null,
                'expire_date' => $new_expire_date,
                'status' => $subscription_status,
            ]);

        } else {
            // Create a new subscription if no existing one found
       $store_sub = StoreSubscription::create([
                'store_id' => $store_id,
                'subscription_id' => $subscription_package->id,
                'name' => $subscription_package->name,
                'type' => $subscription_package->type,
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
                'transaction_ref' => null,
                'manual_image' => null,
                'expire_date' => now()->addDays($subscription_package->validity),
                'status' => $subscription_status,
            ]);
            // Create subscription history
            SubscriptionHistory::create([
                'store_subscription_id' => $store_sub->id,
                'store_id' => $store_id,
                'subscription_id' => $subscription_package->id,
                'name' => $subscription_package->name,
                'type' => $subscription_package->type,
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
                'transaction_ref' =>  null,
                'manual_image' =>  null,
                'expire_date' => now()->addDays($subscription_package->validity),
                'status' => $subscription_status,
            ]);
        }

        $store->update(['subscription_type' => 'subscription']);


        return [
            'success' => true,
            'message' => 'Subscription successfully purchased.',
        ];

    }

    public function renewSubscriptionPackage($store_id, $subscription_id, $request_payment_gateway)
    {
        // Authenticate user
        $seller = Auth::guard('api')->user();
        if (!$seller) {
            return [
                'success' => false,
                'message' => 'User is not authenticated.',
            ];
        }

        // Fetch the store
        $store = Store::find($store_id);
        if (!$store || $store->store_seller_id != $seller->id) {
            return [
                'success' => false,
                'message' => 'Store not found or access denied.',
            ];
        }

        // Ensure store subscription type is valid
        if ($store->subscription_type !== 'subscription') {
            return [
                'success' => false,
                'message' => 'Invalid subscription type for the store.',
            ];
        }

        // Fetch the active subscription
        $currentSubscription = StoreSubscription::where('store_id', $store_id)->first();
        if (!$currentSubscription) {
            return [
                'success' => false,
                'message' => 'No active subscription found for the store.',
            ];
        }

        // Fetch the subscription package
        $subscriptionPackage = Subscription::where('id', $subscription_id)
            ->where('status', 1)
            ->first();

        if (!$subscriptionPackage) {
            return [
                'success' => false,
                'message' => 'Subscription package not found.',
            ];
        }

        // Determine payment gateway and status
        $payment_gateway = $request_payment_gateway ?? null;
        $payment_status = $payment_gateway === 'wallet' ? 'paid' : 'pending';
        $subscription_status = $payment_gateway === 'wallet' ? 1 : 0;


        // Calculate the new expiration date
        $newExpireDate = Carbon::parse($currentSubscription->expire_date)->gt(now())
            ? Carbon::parse($currentSubscription->expire_date)->addDays($subscriptionPackage->validity)
            : now()->addDays($subscriptionPackage->validity);


        // Create subscription history
        SubscriptionHistory::create([
            'store_subscription_id' => $currentSubscription->id,
            'store_id' => $store_id,
            'subscription_id' => $subscriptionPackage->id,
            'name' => $subscriptionPackage->name,
            'type' => $subscriptionPackage->type,
            'validity' => $subscriptionPackage->validity,
            'price' => $subscriptionPackage->price,
            'pos_system' => $subscriptionPackage->pos_system,
            'self_delivery' => $subscriptionPackage->self_delivery,
            'mobile_app' => $subscriptionPackage->mobile_app,
            'live_chat' => $subscriptionPackage->live_chat,
            'order_limit' => $subscriptionPackage->order_limit,
            'product_limit' => $subscriptionPackage->product_limit,
            'product_featured_limit' => $subscriptionPackage->product_featured_limit,
            'payment_gateway' => $payment_gateway,
            'payment_status' => $payment_status,
            'transaction_ref' => null,
            'manual_image' => null,
            'expire_date' => $newExpireDate,
            'status' => $subscription_status,
        ]);

        // Update or create the current subscription
        $currentSubscription->update([
            'subscription_id' => $subscriptionPackage->id,
            'name' => $subscriptionPackage->name,
            'type' => $subscriptionPackage->type,
            'validity' => $subscriptionPackage->validity,
            'price' => $subscriptionPackage->price,
            'pos_system' => $subscriptionPackage->pos_system,
            'self_delivery' => $subscriptionPackage->self_delivery,
            'mobile_app' => $subscriptionPackage->mobile_app,
            'live_chat' => $subscriptionPackage->live_chat,
            'order_limit' => $subscriptionPackage->order_limit,
            'product_limit' => $subscriptionPackage->product_limit,
            'product_featured_limit' => $subscriptionPackage->product_featured_limit,
            'payment_gateway' => $payment_gateway,
            'payment_status' => $payment_status,
            'transaction_ref' => null,
            'manual_image' => null,
            'expire_date' => $newExpireDate,
            'status' => $subscription_status,
        ]);


        return [
            'success' => false,
            'message' => 'Subscription renewed successfully.',
        ];

    }




    public function adminAssignStoreSubscription($data)
    {
        // Authenticate user
        $seller = Auth::guard('api')->user();
        if (!$seller) {
            return [
                'success' => false,
                'message' => 'User is not authenticated.',
            ];
        }

        $store_id = $data['store_id'];
        $subscription_id = $data['subscription_id'];
        $payment_gateway = $data['payment_gateway'];

        // Find the store
        $store = Store::find($store_id);
        if (!$store) {
            return [
                'success' => false,
                'message' => 'Store not found.',
            ];
        }

        // Find the subscription package
        $subscription_package = Subscription::where('id', $subscription_id)
            ->where('status', 1)
            ->first();

        // If package not found
        if (empty($subscription_package)) {
            return [
                'success' => false,
                'status_code' => 409,
                'message' => 'Subscription package not found.',
            ];
        }

        // Set default values for payment status
        $subscription_status = 0;
        $payment_status = $data['payment_status'];

        // Check for existing subscription and update if found
        $existing_subscription = StoreSubscription::where('store_id', $store_id)
            ->where('subscription_id', $subscription_package->id)
            ->first();

        if (!$existing_subscription) {
            $store_sub = StoreSubscription::create([
                'store_id' => $store_id,
                'subscription_id' => $subscription_package->id,
                'name' => $subscription_package->name,
                'type' => $subscription_package->type,
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
                'transaction_ref' => null,
                'manual_image' => null,
                'expire_date' => now()->addDays($subscription_package->validity),
                'status' => $subscription_status,
            ]);
            // Create subscription history
            SubscriptionHistory::create([
                'store_subscription_id' => $store_sub->id,
                'store_id' => $store_id,
                'subscription_id' => $subscription_package->id,
                'name' => $subscription_package->name,
                'type' => $subscription_package->type,
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
                'transaction_ref' =>  null,
                'manual_image' =>  null,
                'expire_date' => now()->addDays($subscription_package->validity),
                'status' => $subscription_status,
            ]);
            $store->update(['subscription_type' => 'subscription']);
            return [
                'success' => true,
                'message' => 'Subscription successfully purchased.',
                'status_code' => 201
            ];
        }else{
            return [
                'success' => false,
                'message' => 'Subscription already exists.',
                'status_code' => 409
            ];
        }

        // fallback
        return [
            'success' => false,
            'message' => 'Failed to assign subscription.',
            'status_code' => 500,
        ];

    }


}
