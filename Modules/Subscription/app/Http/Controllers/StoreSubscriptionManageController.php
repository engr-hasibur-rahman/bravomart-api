<?php

namespace Modules\Subscription\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ComMerchantStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Subscription\app\Models\ComMerchantStoresSubscription;
use Modules\Subscription\app\Models\Subscription;

class StoreSubscriptionManageController extends Controller
{
    public function index(Request $request)
    {
        $seller = Auth::guard('api')->user();
        $store_id = $request->store_id;

        $seller_all_stores_ids = ComMerchantStore::where('merchant_id', $seller->id)
            ->pluck('store_id')
            ->toArray();

        if (!in_array($store_id, $seller_all_stores_ids)) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found or not associated with this seller',
            ], 404);
        }

        $store_subscription_history = ComMerchantStoresSubscription::where('store_id', $store_id)->get();

        return response()->json([
            'success' => true,
            'store_subscription_history' => $store_subscription_history,
        ]);
    }

}
