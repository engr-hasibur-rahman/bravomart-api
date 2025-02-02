<?php

namespace App\Services;

use App\Jobs\SendStoreCreatedEmailJob;
use App\Models\Store;
use App\Models\SystemCommission;
use Illuminate\Support\Arr;
use Modules\Subscription\app\Services\SubscriptionService;

class StoreManageService
{

    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService = null)
    {
        // Only assign SubscriptionService if the module exists and is active
        if (moduleExistsAndStatus('Subscription')) {
            $this->subscriptionService = $subscriptionService;
        }
    }

    public function storeForAuthSeller($data)
    {

        $data = Arr::except($data, ['translations']);
        $data['merchant_id'] = auth('api')->id();
        $store = Store::create($data);

        // store create after commission set
        $store = Store::find($store->id);
        $store_id = $store->id;
        if (isset($store->subscription_type) && $store->subscription_type === 'commission') {
            // get system commission
            $system_commission = SystemCommission::first();

            // Ensure the commission type is valid
            $commission_type = $system_commission->commission_type;
            if ($commission_type !== 'commission' && $commission_type !== 'fixed') {
                $commission_type = 'commission'; // Default value
            }

            // Update store commission
            $store->admin_commission_type = $commission_type;
            $store->admin_commission_amount = $system_commission->commission_amount;
            $store->save();

            // Dispatch job to send email in the background
            try {
                dispatch(new SendStoreCreatedEmailJob($store));
            } catch (\Exception $exception) {
            }
            return [
                'store_id' => $store_id,
                'slug' => $store->slug,
            ];
        }

        // Store Subscription handle logic
        if (moduleExistsAndStatus('Subscription')) {
            $this->subscriptionService->buySubscriptionPackage($store, $data);
        }

        return [
            'store_id' => $store_id,
            'slug' => $store->slug,
        ];

    }


    public function storeUpdateForAuthSeller($data)
    {

        $store = Store::findOrFail($data['id']);
        if ($store) {
            $data = Arr::except($data, ['translations']);
            $store->update($data);
        }

        $store_id = $store->id;
        if (isset($store->subscription_type) && $store->subscription_type === 'commission') {
            // get system commission
            $system_commission = SystemCommission::first();
            // update store commission
            $store->admin_commission_type = $system_commission->commission_type;
            $store->admin_commission_amount = $system_commission->commission_amount;
            $store->save();

            // Dispatch job to send email in the background
            try {
                dispatch(new SendStoreCreatedEmailJob($store));
            } catch (\Exception $exception) {
            }
            return [
                'store_id' => $store_id,
                'slug' => $store->slug,
            ];
        }
        // Store Subscription handle logic
        if (moduleExistsAndStatus('Subscription')) {
            $this->subscriptionService->renewSubscriptionPackage($store, $data);
        }
        return [
            'store_id' => $store_id,
            'slug' => $store->slug,
        ];
    }
}
