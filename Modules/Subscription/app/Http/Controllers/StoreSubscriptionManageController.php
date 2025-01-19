<?php

namespace Modules\Subscription\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Models\ComMerchantStore;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Modules\Subscription\app\Models\ComMerchantStoresSubscription;
use Modules\Subscription\app\Transformers\StoreSubscriptionHistoryResource;

class StoreSubscriptionManageController extends Controller
{
    public function subscriptionPackageHistory(Request $request)
    {
        // Get the authenticated seller
        $seller = Auth::guard('api')->user();
        $store_id = $request->store_id;

        // get seller store
        $store = ComMerchantStore::where('id', $store_id)->where('merchant_id', $seller->id)->first();

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found'
            ], 404);
        }

        $store_subscription_history = ComMerchantStoresSubscription::where('store_id', $store_id)->paginate(10);

        return response()->json([
            'success' => true,
            'subscription_history' => StoreSubscriptionHistoryResource::collection($store_subscription_history),
            'meta' => new PaginationResource($store_subscription_history),
        ]);
    }




}
