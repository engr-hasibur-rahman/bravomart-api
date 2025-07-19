<?php

namespace App\Http\Controllers\Api\V1\Com;

use App\Actions\ImageModifier;
use App\Http\Controllers\Api\V1\Controller;
use App\Http\Resources\Com\GdprPublicResource;
use App\Http\Resources\Com\SiteGeneralInfoFilterLogoResource;
use App\Http\Resources\Com\SiteGeneralInfoResource;
use App\Models\SettingOption;
use Illuminate\Http\Request;

class ComSiteGeneralController extends Controller
{
    public function siteGeneralInfo(Request $request)
    {

        $filter_data = $request->filter;
        if ($filter_data == 'logo') {
            $site_settings = [
                'com_site_logo' => com_option_get('com_site_logo'),
                'com_site_white_logo' => com_option_get('com_site_white_logo'),
                'com_site_favicon' => com_option_get('com_site_favicon'),
            ];
            return response()->json([
                'site_settings' => new SiteGeneralInfoFilterLogoResource($site_settings),
            ]);
        } else {
            $site_settings = [
                'com_site_title' => com_option_get('com_site_title'),
                'com_site_subtitle' => com_option_get('com_site_subtitle'),
                'com_site_favicon' => com_option_get('com_site_favicon'),
                'com_site_logo' => com_option_get('com_site_logo'),
                'com_site_white_logo' => com_option_get('com_site_white_logo'),
                'com_site_footer_copyright' => com_option_get('com_site_footer_copyright'),
                'com_site_email' => com_option_get('com_site_email'),
                'com_site_website_url' => com_option_get('com_site_website_url'),
                'com_site_contact_number' => com_option_get('com_site_contact_number'),
                'com_site_full_address' => com_option_get('com_site_full_address'),
                'com_maintenance_mode' => com_option_get('com_maintenance_mode'),
                'com_user_login_otp' => com_option_get('com_user_login_otp'),
                'com_user_email_verification' => com_option_get('com_user_email_verification'),
                'com_google_recaptcha_v3_site_key' => com_option_get('com_google_recaptcha_v3_site_key'),
                'com_google_recaptcha_v3_secret_key' => com_option_get('com_google_recaptcha_v3_secret_key'),
                'com_google_recaptcha_enable_disable' => com_option_get('com_google_recaptcha_enable_disable'),
                'otp_login_enabled_disable' => com_option_get('otp_login_enabled_disable'),
            ];
        }

        return response()->json([
            'site_settings' => new SiteGeneralInfoResource($site_settings),
        ]);
    }

    public function siteMaintenancePage(Request $request)
    {
        $settings = [
            'com_maintenance_title' => com_option_get('com_maintenance_title'),
            'com_maintenance_description' => com_option_get('com_maintenance_description'),
            'com_maintenance_start_date' => com_option_get('com_maintenance_end_date'),
            'com_maintenance_end_date' => com_option_get('com_maintenance_end_date'),
            'com_maintenance_image' => ImageModifier::generateImageUrl(com_option_get('com_maintenance_image'))
        ];
        return response()->json([
            'maintenance_settings' => $settings,
        ]);
    }

    public function googleMapSettings(Request $request)
    {
        $com_google_map_enable_disable = com_option_get('com_google_map_enable_disable');
        $com_google_map_api_key = com_option_get('com_google_map_api_key');
        return $this->success([
            'com_google_map_enable_disable' => $com_google_map_enable_disable,
            'com_google_map_api_key' => $com_google_map_api_key,
        ]);
    }

    public function gdprCookieSettings(Request $request)
    {
        $settings = SettingOption::with('related_translations')
            ->where('option_name', 'gdpr_data')
            ->first();

        if (!$settings) {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }

        // Decode content only if it's a string
        if (is_string($settings->content)) {
            $decoded = json_decode($settings->content, true);

            // Only assign if decoding is successful
            if (json_last_error() === JSON_ERROR_NONE) {
                $settings->content = $decoded;
            } else {
                $settings->content = [];
            }
        }

        return response()->json([
            'data' => new GdprPublicResource($settings),
        ]);
    }
}
