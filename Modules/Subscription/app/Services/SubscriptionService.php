<?php

namespace Modules\Subscription\app\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Subscription\app\Models\Subscription;

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

        // Business logic for purchasing the subscription
        $seller->subscription_id = $subscription_package->id;
        $seller->subscription_expiry = now()->addDays($subscription_package->validity);
        $seller->save();

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
