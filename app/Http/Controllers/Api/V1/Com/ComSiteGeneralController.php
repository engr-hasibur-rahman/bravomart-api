<?php

namespace App\Http\Controllers\Api\V1\Com;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\SiteGeneralInfoFilterResource;
use App\Http\Resources\Com\SiteGeneralInfoResource;
use Illuminate\Http\Request;

class ComSiteGeneralController extends Controller
{
    public function siteGeneralInfo(Request $request){

        $filter_data = $request->filter;

        $allowed_filters = [
            'logo' => 'com_site_logo',
            'white-logo' => 'com_site_white_logo',
            'favicon' => 'com_site_favicon',
            'maintenance' => 'com_maintenance_mode',
            'email-verification' => 'com_user_email_verification',
        ];

        if (array_key_exists($filter_data, $allowed_filters)) {
            $key = $allowed_filters[$filter_data];
            $site_settings = [
                $key => com_option_get('com_site_' . $key),
            ];
            return response()->json([
                'site_settings' => new SiteGeneralInfoFilterResource($site_settings),
            ]);
        }

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
            'site_settings' => New SiteGeneralInfoResource($site_settings),
        ]);
    }
}
