<?php

namespace Modules\Subscription\app\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Subscription\app\Models\Subscription;
use Modules\Subscription\app\Models\SubscriptionHistory;


class SubscriptionService
{
    public function buySubscriptionPackage($request)
    {
        // Authenticate user
        $seller = Auth::guard('api')->user();
        if (!$seller) {
            return [
                'success' => false,
                'message' => 'User is not authenticated.',
            ];
        }

        // Validate subscription package
        $subscription_package = Subscription::where('id', $request->subscription_id)
            ->where('status', 1)
            ->first();

        if (!$subscription_package) {
            return [
                'success' => false,
                'message' => 'Invalid subscription ID or the package is inactive.',
            ];
        }

        $payment_gateway = $request->payment_gateway;
        $payment_status = 'pending';

        if($subscription_package){
            // Create subscription history
            $subscriptionHistory = SubscriptionHistory::create([
                'subscription_id' => $request->subscription_id,
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
                'payment_gateway' => $request->payment_gateway,
                'payment_status' => $payment_status,
                'transaction_id' => $request->transaction_id, // Make sure to pass this in the request
                'manual_image' => $request->manual_image, // Optional field
                'expire_date' => now()->addDays($subscription_package->validity),
                'status' => 0,
            ]);
        }

        return [
            'success' => true,
            'message' => 'Subscription package purchased successfully.',
            'data' => [
                'subscription_name' => $subscription_package->name,
                'validity' => $subscription_package->validity . ' days',
                'expires_at' => $seller->subscription_expiry,
            ],
        ];
    }
}
