<?php

namespace App\Http\Resources\Com;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteGeneralInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'com_site_title' => com_option_get('com_site_title'),
            'com_site_subtitle' => com_option_get('com_site_subtitle'),
            'com_site_favicon' => ImageModifier::generateImageUrl(com_option_get('com_site_favicon')),
            'com_site_logo' => ImageModifier::generateImageUrl(com_option_get('com_site_logo')),
            'com_site_white_logo' => ImageModifier::generateImageUrl(com_option_get('com_site_white_logo')),
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
        ];
    }
}
