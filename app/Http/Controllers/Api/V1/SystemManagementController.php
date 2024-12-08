<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\ImageModifier;
use App\Http\Controllers\Controller;
use App\Models\SystemManagement;
use Illuminate\Http\Request;

class SystemManagementController extends Controller
{
    public function generalSettings(Request $request){
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'com_site_logo' => 'nullable|string',
                'com_site_favicon' => 'nullable|string',
                'com_site_title' => 'nullable|string',
                'com_site_subtitle' => 'nullable|string',
                'com_user_email_verification' => 'nullable|string',
                'com_user_login_otp' => 'nullable|string',
                'com_maintenance_mode' => 'nullable|string',
            ]);

            $fields = ['com_site_logo', 'com_site_favicon', 'com_site_title', 'com_site_subtitle', 'com_user_email_verification', 'com_user_login_otp', 'com_maintenance_mode'];
            foreach ($fields as $field) {
                  $value = $request->input($field) ?? null;
                  com_option_update($field, $value);

            }
            return $this->success(translate('messages.update_success', ['name' => 'General Settings']));
        }else{
            // Create an instance of ImageModifier
            $imageModifier = new ImageModifier();
            $com_site_logo = $imageModifier->generateImageUrl(com_option_get('com_site_logo'));
            $com_site_favicon = $imageModifier->generateImageUrl(com_option_get('com_site_favicon'));
            $com_site_title = com_option_get('com_site_title') ?? '';
            $com_site_subtitle = com_option_get('com_site_subtitle') ?? '';
            $com_user_email_verification = com_option_get('com_user_email_verification') ?? '';
            $com_user_login_otp = com_option_get('com_user_login_otp') ?? '';
            $com_maintenance_mode = com_option_get('com_maintenance_mode') ?? '';

            return $this->success([
                'com_site_logo' => $com_site_logo,
                'com_site_favicon' => $com_site_favicon,
                'com_site_title' => $com_site_title,
                'com_site_subtitle' => $com_site_subtitle,
                'com_user_email_verification' => $com_user_email_verification,
                'com_user_login_otp' => $com_user_login_otp,
                'com_maintenance_mode' => $com_maintenance_mode,
            ]);
        }

    }
}
