<?php

namespace Modules\PaymentGateways\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\PaymentGateways\app\Models\PaymentGateway;

class PaymentGatewaysController extends Controller
{
    public function settingsGetAndUpdate(Request $request, $gateway)
    {
        if ($request->isMethod('POST')) {

            if (!empty($request->currency_settings) && $request->currency_settings === 'update') {
                // Define a common prefix for all keys
                $commonPrefix = 'com_site_';

                // Get the global currency, with a default value if not set
                $globalCurrency = strtolower(com_option_get("{$commonPrefix}global_currency") ?? 'default_currency');

                // Define validation rules
                $fieldRules = [
                    "{$commonPrefix}global_currency" => 'nullable|string|max:191',
                    "{$commonPrefix}payment_gateway" => 'nullable|string|max:191',
                    "{$commonPrefix}manual_payment_name" => 'nullable|string|max:191',
                    "{$commonPrefix}manual_payment_description" => 'nullable|string|max:191',
                    "{$commonPrefix}usd_to_ngn_exchange_rate" => 'nullable|string|max:191',
                    "{$commonPrefix}euro_to_ngn_exchange_rate" => 'nullable|string|max:191',
                    "{$commonPrefix}currency_symbol_position" => 'nullable|string|max:191',
                    "{$commonPrefix}default_payment_gateway" => 'nullable|string|max:191',
                ];

                // Add dynamic currency exchange rules
                $exchangeRates = ['idr', 'inr', 'ngn', 'zar', 'brl', 'myr', 'usd'];
                foreach ($exchangeRates as $currency) {
                    $fieldRules["{$commonPrefix}{$globalCurrency}_to_{$currency}_exchange_rate"] = 'nullable|string|max:191';
                }

                // Validate the request
                $this->validate($request, $fieldRules);

                // Update all options dynamically
                foreach ($fieldRules as $field => $rule) {
                    com_option_update($field, $request->$field ?? null);
                }

                // Update specific payment gateway settings
                $paymentSettings = [
                    'common_form_adjustment_amount' => 'nullable|string|max:191',
                    'enable_disable_decimal_point' => 'nullable|boolean',
                    'space_between_amount_and_symbol' => 'nullable|boolean',
                ];

                foreach ($paymentSettings as $key => $rule) {
                    $field = "{$commonPrefix}{$key}";
                    com_option_update($field, $request->$key ?? null);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Currency settings updated successfully.',
                ]);
            }


            // Perform validation directly on the request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|exists:payment_gateways,name',
                'description' => 'nullable|string',
                'auth_credentials' => 'required|array',
                'status' => 'required|boolean',
                'is_test_mode' => 'required|boolean',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Get validated data
            $validatedData = $validator->validated();

            // Proceed with business logic using $validatedData
            $gateway = PaymentGateway::where('name', $validatedData['name'])->first();


            if (!$gateway) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid gateway name.'
                ], 400);
            }

            $auth_credentials = $request->get('auth_credentials', []);
            $gateway->update([
                'image' => $request->get('image', $gateway->image),
                'description' => $request->get('description', $gateway->description),
                'status' => $request->get('status', $gateway->status),
                'is_test_mode' => $request->get('is_test_mode', $gateway->is_test_mode),
                'auth_credentials' => json_encode($auth_credentials),
            ]);

            Artisan::call('optimize:clear');

            return response()->json([
                'status' => 'success',
                'message' => 'Payment gateway updated successfully.'
            ]);
        }

        if (!empty($request->currency_settings) && $request->currency_settings == 'get') {
            // Example: Get all relevant currency settings
            $currencySettings = [
                'com_site_global_currency' => com_option_get('com_site_global_currency'),
                'com_site_default_currency_to_usd_exchange_rate' => com_option_get('com_site_default_currency_to_usd_exchange_rate'),
                'com_site_default_currency_to_myr_exchange_rate' => com_option_get('com_site_default_currency_to_myr_exchange_rate'),
                'com_site_default_currency_to_brl_exchange_rate' => com_option_get('com_site_default_currency_to_brl_exchange_rate'),
                'com_site_default_currency_to_zar_exchange_rate' => com_option_get('com_site_default_currency_to_zar_exchange_rate'),
                'com_site_default_currency_to_ngn_exchange_rate' => com_option_get('com_site_default_currency_to_ngn_exchange_rate'),
            ];

            // Return the current currency settings as JSON
            return response()->json([
                'status' => 'success',
                'currency_settings' => $currencySettings,
            ]);
        }

        $paymentGateway = PaymentGateway::where('name', $gateway)->first();
        if (!$paymentGateway) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment gateway not found.'
            ], 404);
        }
        $paymentGateway->auth_credentials = json_decode($paymentGateway->auth_credentials);
        return response()->json([
            'status' => 'success',
            'gateways' => $paymentGateway
        ]);
    }

}
