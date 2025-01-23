<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Store\SellerStoreCommissionResource;
use App\Models\ComMerchantStore;
use Illuminate\Http\Request;
use Modules\Subscription\app\Models\ComMerchantStoresSubscription;

class SellerBusinessSettingsController extends Controller
{
    public function businessPlanInfo(Request $request){

        $seller_id = auth()->guard('api')->id();

        $store = ComMerchantStore::where('id', $request->store_id)
            ->where('merchant_id', $seller_id)
            ->first();

        if (!$store) {
            return response()->json([
                'message' => 'Store not found or you do not have access to this store.',
            ], 404);
        }

        // Subscription package logic
        if (moduleExists('Subscription')) {
            if ($store->subscription_type === 'subscription'){
                // Instantiate the service and get the subscription
                $subscriptionService = new \Modules\Subscription\app\Services\StoreSubscriptionManageService();
                $store_subscription = $subscriptionService->storeSubscriptionInfo($store->id);

                return response()->json([
                    'store' => new SellerStoreCommissionResource($store),
                    'store_subscription' => $store_subscription
                ]);
            }
        }

        // If no subscription type is found, return store commission info
        return response()->json([
            'store' => new SellerStoreCommissionResource($store)
        ]);

    }

    public function businessPlanChange(Request $request){
        $seller_id = auth()->guard('api')->id();

        $store = ComMerchantStore::where('id', $request->store_id)
            ->where('merchant_id', $seller_id)
            ->first();

        if (!$store) {
            return response()->json([
                'message' => 'Store not found or you do not have access to this store.',
            ], 404);
        }

        // set type
        $subscription_type = 'commission';

        // Subscription package logic
        if (moduleExists('Subscription')) {
            if ($store->subscription_type === 'commission'){
                $subscription_type = 'subscription';
            }
        }

        // change business plan
        $store->update([
            'subscription_type' => $subscription_type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Business plan changed successfully.'
        ]);
    }
}
