<?php

namespace App\Services;

use App\Mail\DynamicEmail;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GlobalEmailService
{
    public function DispatchOrderEmails($all_orders, $system_global_email)
    {

        try {
            // Fetch email templates in one query
            $email_templates = EmailTemplate::whereIn('type', ['order-created', 'order-created-store', 'order-created-admin'])
                ->where('status', 1)
                ->get()
                ->keyBy('type');

            if (!$email_templates->has('order-created') || !$email_templates->has('order-created-store') || !$email_templates->has('order-created-admin')) {
                throw new \Exception('Missing email templates');
            }

            foreach ($all_orders as $order) {
                // Fetch emails
                $customer_email = $order->orderAddress?->email ?? $order->orderMaster?->customer?->email;
                $store_email = $order->store?->email;
                $store_owner_name = $order->store?->seller?->full_name ?? __('Store Owner');

                // Get email template data
                $customer_subject = $email_templates['order-created']->subject;
                $store_subject = $email_templates['order-created-store']->subject;
                $admin_subject = $email_templates['order-created-admin']->subject;

                // Replace placeholders dynamically
                $order_amount = amount_with_symbol_format($order->order_amount);

                $customer_message = str_replace(
                    ["@customer_name", "@order_id", "@order_amount"],
                    [$order->orderMaster?->customer?->full_name, $order->id, $order_amount],
                    $email_templates['order-created']->body
                );

                $store_message = str_replace(
                    ["@store_owner_name", "@store_name", "@order_id", "@order_amount"],
                    [$store_owner_name, $order->store?->name, $order->id, $order_amount],
                    $email_templates['order-created-store']->body
                );


                $admin_message = str_replace(
                    ["@order_id", "@order_amount"],
                    [$order->id, $order_amount],
                    $email_templates['order-created-admin']->body
                );

                // Send emails asynchronously using queues
                if ($customer_email) {
                    Mail::to($customer_email)->queue(new DynamicEmail($customer_subject, (string) $customer_message));

                }
                if ($store_email) {
                    Mail::to($store_email)->queue(new DynamicEmail($store_subject, (string) $store_message));
                }
                if ($system_global_email) {
                    Mail::to($system_global_email)->queue(new DynamicEmail($admin_subject, (string) $admin_message));
                }
            }
        } catch (\Exception $e) {
        }
    }


}