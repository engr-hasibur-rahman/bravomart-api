<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminCommissionManageController extends Controller
{
    public function commissionSettings(Request $request)
    {
        if ($request->isMethod('POST')) {

            // Validation rules for the input fields
            $validator = Validator::make($request->all(), [
                'com_commission_enabled' => 'nullable',
                'com_subscription_enabled' => 'nullable',
                'com_default_order_commission_rate' => 'nullable|numeric|max:255',
                'com_default_delivery_commission_charge' => 'nullable|numeric|max:255',
                'com_order_shipping_charge' => 'nullable|numeric|max:255',
                'com_order_confirmation_by' => 'nullable',
                'com_order_include_tax_amount' => 'nullable',
                'com_order_additional_charge_enable_disable' => 'nullable',
                'com_order_additional_charge_name' => 'nullable|string|max:255',
                'com_order_additional_charge_amount' => 'nullable|numeric|max:255',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            com_option_update('com_order_additional_charge_amount', $request->com_order_additional_charge_amount ?? null);
            com_option_update('com_order_additional_charge_name', $request->com_order_additional_charge_name ?? null);
            com_option_update('com_order_additional_charge_enable_disable', $request->com_order_additional_charge_enable_disable ?? null);
            com_option_update('com_order_include_tax_amount', $request->com_order_include_tax_amount ?? null);
            com_option_update('com_order_shipping_charge', $request->com_order_shipping_charge ?? null);
            com_option_update('com_default_delivery_commission_charge', $request->com_default_delivery_commission_charge ?? null);
            com_option_update('com_default_order_commission_rate', $request->com_default_order_commission_rate ?? null);

            com_option_update('com_commission_enabled', $request->com_commission_enabled ?? null);
            com_option_update('com_subscription_enabled', $request->com_subscription_enabled ?? null);
            com_option_update('com_order_confirmation_by', $request->com_order_confirmation_by ?? null);


            // Return success response
            return $this->success(translate('messages.update_success', ['name' => 'Commission Settings']));
        }

        // Handle GET request
        $response = [
            'com_order_additional_charge_amount' => com_option_get('com_order_additional_charge_amount'),
            'com_order_additional_charge_name' => com_option_get('com_order_additional_charge_name'),
            'com_order_additional_charge_enable_disable' => com_option_get('com_order_additional_charge_enable_disable'),
            'com_order_include_tax_amount' => com_option_get('com_order_include_tax_amount'),
            'com_order_shipping_charge' => com_option_get('com_order_shipping_charge'),
            'com_default_delivery_commission_charge' => com_option_get('com_default_delivery_commission_charge'),
            'com_default_order_commission_rate' => com_option_get('com_default_order_commission_rate'),
            'com_commission_enabled' => com_option_get('com_commission_enabled'),
            'com_subscription_enabled' => com_option_get('com_subscription_enabled'),
            'com_order_confirmation_by' => com_option_get('com_order_confirmation_by'),
        ];

        return $this->success($response);
    }

    public function commissionHistory(Request $request)
    {

        return $this->success('test');
    }

}
