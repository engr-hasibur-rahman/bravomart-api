<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\ImageModifier;
use App\Http\Controllers\Controller;
use App\Interfaces\TranslationInterface;
use App\Models\ComOption;
use App\Models\SystemManagement;
use Illuminate\Http\Request;

class SystemManagementController extends Controller
{
    public function __construct(
        protected TranslationInterface $transRepo,
        protected ComOption $get_com_option,
    ) {}

    public function translationKeys(): mixed
    {
        return $this->get_com_option->translationKeys;
    }

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

            // Define the fields that need to be translated
            $fields = ['com_site_title', 'com_site_subtitle'];
            $com_options = ComOption::whereIn('option_name', $fields)->get(['id']);

            foreach ($com_options as $com_option) {
                $this->transRepo->storeTranslation($request, $com_option->id, 'App\Models\ComOption', $this->translationKeys());
            }

            return $this->success(translate('messages.update_success', ['name' => 'General Settings']));
        }else{
            // Create an instance of ImageModifier
            $imageModifier = new ImageModifier();
            $com_site_logo = com_option_get('com_site_logo');
            $com_site_favicon = com_option_get('com_site_favicon');
            $com_site_logo_image_url = $imageModifier->generateImageUrl(com_option_get('com_site_logo'));
            $com_site_favicon_image_url = $imageModifier->generateImageUrl(com_option_get('com_site_favicon'));
            $com_site_title = com_option_get('com_site_title') ?? '';
            $com_site_subtitle = com_option_get('com_site_subtitle') ?? '';
            $com_user_email_verification = com_option_get('com_user_email_verification') ?? '';
            $com_user_login_otp = com_option_get('com_user_login_otp') ?? '';
            $com_maintenance_mode = com_option_get('com_maintenance_mode') ?? '';

            return $this->success([
                'com_site_logo' => $com_site_logo,
                'com_site_favicon' => $com_site_favicon,
                'com_site_logo_image_url' => $com_site_logo_image_url,
                'com_site_favicon_image_url' => $com_site_favicon_image_url,
                'com_site_title' => $com_site_title,
                'com_site_subtitle' => $com_site_subtitle,
                'com_user_email_verification' => $com_user_email_verification,
                'com_user_login_otp' => $com_user_login_otp,
                'com_maintenance_mode' => $com_maintenance_mode,
            ]);
        }

    }
}
