<?php

namespace Modules\Subscription\app\Services;

use Modules\Subscription\app\Models\ComMerchantStoresSubscription;

class StoreSubscriptionManageService
{
    public function storeSubscriptionInfo($storeId)
    {

        $store_subscription = ComMerchantStoresSubscription::where('store_id', $storeId)->first();

        if (!$store_subscription) {
            return false;
        }

        return $store_subscription;
    }
}
