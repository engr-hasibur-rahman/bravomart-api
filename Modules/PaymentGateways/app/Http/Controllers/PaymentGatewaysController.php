<?php

namespace Modules\PaymentGateways\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\PaymentGateways\app\Models\PaymentGateway;
use Modules\PaymentGateways\app\Transformers\PaymentGatewaysListPublicResource;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Currency;


class PaymentGatewaysController extends Controller
{
    public function siteGeneralInfo(){
        $site_settings = [
            'com_site_title' => com_option_get('com_site_title'),
            'com_site_subtitle' => com_option_get('com_site_subtitle'),
            'com_site_favicon' => com_option_get('com_site_favicon'),
            'com_site_logo' => com_option_get('com_site_logo'),
            'com_site_footer_copyright' => com_option_get('com_site_footer_copyright'),
            'com_site_email' => com_option_get('com_site_email'),
            'com_site_website_url' => com_option_get('com_site_website_url'),
            'com_site_contact_number' => com_option_get('com_site_contact_number'),
            'com_site_full_address' => com_option_get('com_site_full_address'),
            'com_maintenance_mode' => com_option_get('com_maintenance_mode'),
            'com_user_login_otp' => com_option_get('com_user_login_otp'),
            'com_user_email_verification' => com_option_get('com_user_email_verification'),
        ];

        return response()->json([
            'site_settings' => $site_settings,
        ]);
    }

    public function currencySettingsGet(){
        $currencies = [
            'com_site_global_currency' => com_option_get('com_site_global_currency'),
            'com_site_currency_symbol_position' => com_option_get('com_site_currency_symbol_position'),
            'com_site_default_currency_to_usd_exchange_rate' => com_option_get('com_site_default_currency_to_usd_exchange_rate'),
            'com_site_comma_form_adjustment_amount' => com_option_get('com_site_comma_form_adjustment_amount'),
            'com_site_enable_disable_decimal_point' => com_option_get('com_site_enable_disable_decimal_point'),
            'com_site_space_between_amount_and_symbol' => com_option_get('com_site_space_between_amount_and_symbol'),
        ];
        return response()->json([
            'currencies_info' => $currencies,
        ]);
    }

    public function paymentGateways(){
        $paymentGateways = PaymentGateway::where('status', 1)->get();
        return response()->json([
            'paymentGateways' => PaymentGatewaysListPublicResource::collection($paymentGateways),
        ]);
    }

}
