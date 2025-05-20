<?php

namespace App\Services;

use App\Jobs\SendDynamicEmailJob;
use App\Jobs\SendStoreCreatedEmailJob;
use App\Models\EmailTemplate;
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

        $data['store_id'] = $store->id;

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
            }
            $seller = auth('api')->user();
            // Send email to seller register in background
            try {

                $seller_email = $seller->email;
                $seller_phone = $seller->phone;
                $seller_name = $seller->first_name . ' ' . $seller->last_name;
                $store_name = $store->name;

                $system_global_title = com_option_get('com_site_title');
                $system_global_email = com_option_get('com_site_email');

                // template
                $email_template_seller = EmailTemplate::where('type', 'store-creation')->where('status', 1)->first();
                $email_template_admin = EmailTemplate::where('type', 'store-creation-admin')->where('status', 1)->first();

                // seller
                $seller_subject = $email_template_seller?->subject;
                $seller_message = $email_template_seller?->body;
                // admin
                $admin_subject = $email_template_admin?->subject;
                $admin_message = $email_template_admin?->body;

                $seller_message = str_replace(["@seller_name", "@store_name"], [$seller_name, $store_name], $seller_message);
                $admin_message = str_replace(["@seller_name", "@store_name"], [$seller_name, $store_name], $admin_message);

                // Check if template exists and email is valid and // Send the email using queued job
                if ($email_template_seller) {
                    // mail to seller
                    dispatch(new SendDynamicEmailJob($seller_email, $seller_subject, $seller_message));
                    dispatch(new SendDynamicEmailJob($system_global_email, $admin_subject, $admin_message));

                }
            } catch (\Exception $th) {
            }

        }
        // Store Subscription handle logic
        // check subscription system_commission settings
        if ($data['subscription_type'] == 'subscription' && $subscription_enabled) {
            if (moduleExistsAndStatus('Subscription')) {
                $this->subscriptionService->buySubscriptionPackage($data);
            }
            DB::commit();
        } else {
            DB::rollBack();
        }
        return $store;
    }


    public function storeUpdateForAuthSeller($data)
    {
        $store = Store::find($data['id']);

        if ($store) {
            $data = Arr::except($data, ['translations']);
            $store->update($data);
        }

        $store_id = $store->id;

        return [
            'store_id' => $store_id,
            'slug' => $store->slug,
        ];
    }
}
