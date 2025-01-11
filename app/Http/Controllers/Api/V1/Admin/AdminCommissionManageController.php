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
                'subscription_enabled' => 'nullable',
                'commission_enabled' => 'nullable',
                'com_default_order_commission_rate' => 'nullable|numeric',
                'com_default_delivery_commission_charge' => 'nullable|numeric',
                'com_order_shipping_charge' => 'nullable|numeric',
                'com_order_confirmation_by' => 'nullable|string',
                'com_order_include_tax_amount' => 'nullable',
                'com_order_additional_charge_enable_disable' => 'nullable',
                'com_order_additional_charge_name' => 'nullable|string|max:255',
                'com_order_additional_charge_amount' => 'nullable|numeric|min:0',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            // Retrieve validated data
            $validatedData = $validator->validated();


            // subscription and commission business models
            if ($validatedData['subscription_enabled'] === true && $validatedData['commission_enabled'] === true) {
                $validatedData['com_business_model_type'] = 'commission_subscription_model';
            } elseif ($validatedData['commission_enabled'] == 'commission') {
                $validatedData['com_business_model_type'] = 'commission';
            } elseif ($validatedData['subscription_enabled'] === true) {
                $validatedData['com_business_model_type'] = 'subscription';
            }

            // Fields to update in the system (use the validated data)
            foreach ($validatedData as $field => $value) {
                com_option_update($field, $value); // Update the field using the helper function
            }

            // Return success response
            return $this->success(translate('messages.update_success', ['name' => 'Commission Settings']));
        }

        // Handle GET request
        $response = [
            'com_business_model_type' => com_option_get('com_business_model_type'),
            'com_default_order_commission_rate' => com_option_get('com_default_order_commission_rate'),
            'com_default_delivery_commission_charge' => com_option_get('com_default_delivery_commission_charge'),
            'com_order_shipping_charge' => com_option_get('com_order_shipping_charge'),
            'com_order_confirmation_in_store_or_deliveryman' => com_option_get('com_order_confirmation_in_store_or_deliveryman'),
            'com_order_include_tax_amount' => com_option_get('com_order_include_tax_amount'),
            'com_order_additional_charge_enable_disable' => com_option_get('com_order_additional_charge_enable_disable'),
            'com_order_additional_charge_name' => com_option_get('com_order_additional_charge_name'),
            'com_order_additional_charge_amount' => com_option_get('com_order_additional_charge_amount'),
        ];

        return $this->success($response);
    }

    public function commissionHistory(Request $request)
    {

        return $this->success('test');
    }

}
