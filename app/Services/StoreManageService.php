<?php

namespace App\Services;

use App\Jobs\SendStoreCreatedEmailJob;
use App\Models\ComMerchantStore;
use App\Models\SystemCommission;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Mockery\Exception;
use Modules\Subscription\app\Models\ComMerchantStoresSubscription;
use Modules\Subscription\app\Models\Subscription;
use Modules\Subscription\app\Models\SubscriptionHistory;

class StoreManageService
{

    public function storeForAuthSeller($data){

            $data = Arr::except($data, ['translations']);
            $data['merchant_id'] = auth('api')->id();
            $store = ComMerchantStore::create($data);


            // store create after commission set
               $store = ComMerchantStore::find($store->id);
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

                return $store_id;

            }elseif(isset($store->subscription_type) && $store->subscription_type === 'subscription'){
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
            }
            return $store_id;

    }


    public function storeUpdateForAuthSeller($data){
        try {
            $store = ComMerchantStore::findOrFail($data['id']);
            if ($store) {
                $data = Arr::except($data, ['translations']);
                $store->update($data);
                return $store->id;
            } else {
                return false;
            }
        } catch (\Exception $exception) {
        }
    }


}
