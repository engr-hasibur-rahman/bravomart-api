<?php

namespace App\Services;

use App\Jobs\SendStoreCreatedEmailJob;
use App\Models\Store;
use App\Models\SystemCommission;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
        $data['store_seller_id'] = auth('api')->id();
        DB::beginTransaction();
        $store = Store::create($data);

        // store create after commission set
        $store = Store::find($store->id);
        $store_id = $store->id;
        // check commission system_commission settings
        $systemCommission = SystemCommission::first();
        $commission_enabled = $systemCommission->commission_enabled;
        $subscription_enabled = $systemCommission->subscription_enabled;
        if ($commission_enabled) {
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
                DB::commit();
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
        } else {
            DB::rollBack();
            return [
                'code' => 'commission_option_is_not_available'
            ];
        }
        // Store Subscription handle logic
        // check subscription system_commission settings
        if ($subscription_enabled){
            if (moduleExistsAndStatus('Subscription')) {
                $this->subscriptionService->buySubscriptionPackage($store, $data);
            }
            DB::commit();
        } else {
            DB::rollBack();
            return [
                'code' => 'subscription_option_is_not_available'
            ];
        }
        return $store;
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
