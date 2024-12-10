<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\ImageModifier;
use App\Http\Controllers\Controller;
use App\Interfaces\TranslationInterface;
use App\Models\ComOption;
use App\Models\SystemManagement;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isJson;

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
                // new added
                'com_site_full_address' => 'nullable|string',
                'com_site_contact_number' => 'nullable|string',
                'com_site_website_url' => 'nullable|string',
                'com_site_email' => 'nullable|string',
                'com_site_footer_copyright' => 'nullable|string',
            ]);

            $fields = ['com_site_logo', 'com_site_favicon', 'com_site_title', 'com_site_subtitle', 'com_user_email_verification','com_user_login_otp', 'com_maintenance_mode',
                'com_site_full_address','com_site_contact_number', 'com_site_website_url', 'com_site_email', 'com_site_footer_copyright'
            ];

            foreach ($fields as $field) {
                  $value = $request->input($field) ?? null;
                  com_option_update($field, $value);
            }

            // Define the fields that need to be translated
            $fields = ['com_site_title', 'com_site_subtitle', 'com_site_full_address', 'com_site_contact_number', 'com_site_footer_copyright'];
            $com_options = ComOption::whereIn('option_name', $fields)->get(['id']);

            foreach ($com_options as $com_option) {
                $this->transRepo->storeTranslation($request, $com_option->id, 'App\Models\ComOption', $this->translationKeys());
            }

            return $this->success(translate('messages.update_success', ['name' => 'General Settings']));
        }else{
            // Create an instance of ImageModifier
            $imageModifier = new ImageModifier();

            $ComOptionGet = ComOption::with('translations')->whereIn('option_name', ['com_site_title', 'com_site_subtitle'])
                ->get(['id']);

            // transformed data
            $transformedData = [];
            foreach ($ComOptionGet as $com_option) {
                $translations = $com_option->translations()->get()->groupBy('language');
                foreach ($translations as $language => $items) {
                    $languageInfo = ['language' => $language];
                    /* iterate all Column to Assign Language Value */
                    foreach ($this->get_com_option->translationKeys as $columnName) {
                        $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
                    }
                    $transformedData[] = $languageInfo;
                }
            }

            $com_site_logo = com_option_get('com_site_logo');
            $com_site_favicon = com_option_get('com_site_favicon');
            $com_site_logo_image_url = $imageModifier->generateImageUrl(com_option_get('com_site_logo'));
            $com_site_favicon_image_url = $imageModifier->generateImageUrl(com_option_get('com_site_favicon'));
            $com_site_title = com_option_get('com_site_title') ?? '';
            $com_site_subtitle = com_option_get('com_site_subtitle') ?? '';
            $com_user_email_verification = com_option_get('com_user_email_verification') ?? '';
            $com_user_login_otp = com_option_get('com_user_login_otp') ?? '';
            $com_maintenance_mode = com_option_get('com_maintenance_mode') ?? '';

            // New data
            $com_site_full_address = com_option_get('com_site_full_address') ?? '';
            $com_site_footer_copyright = com_option_get('com_site_footer_copyright') ?? '';
            $com_site_contact_number = com_option_get('com_site_contact_number') ?? '';
            $com_site_website_url = com_option_get('com_site_website_url') ?? '';
            $com_site_email = com_option_get('com_site_email') ?? '';

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
                // New data
                'com_site_full_address' => $com_site_full_address,
                'com_site_footer_copyright' => $com_site_footer_copyright,
                'com_site_contact_number' => $com_site_contact_number,
                'com_site_website_url' => $com_site_website_url,
                'com_site_email' => $com_site_email,
                'translations' => $transformedData,
            ]);


        }

    }

    public function seoSettings(Request $request){
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'com_meta_title' => 'nullable|string',
                'com_meta_description' => 'nullable|string',
                'com_meta_tags' => 'nullable|string',
                'com_canonical_url' => 'nullable|string',
                'com_og_title' => 'nullable|string',
                'com_og_description' => 'nullable|string',
                'com_og_image' => 'nullable|string',
            ]);

            $fields = ['com_meta_title', 'com_meta_description', 'com_meta_tags', 'com_canonical_url', 'com_og_title', 'com_og_description', 'com_og_image'];

            foreach ($fields as $field) {
                  $value = $request->input($field) ?? null;
                  com_option_update($field, $value);
            }

            // Define the fields that need to be translated
            $fields = ['com_meta_title', 'com_meta_description', 'com_meta_tags','com_og_title', 'com_og_description'];
            $com_options = ComOption::whereIn('option_name', $fields)->get(['id']);

            foreach ($com_options as $com_option) {
                $this->transRepo->storeTranslation($request, $com_option->id, 'App\Models\ComOption', $this->translationKeys());
            }

            return $this->success(translate('messages.update_success', ['name' => 'SEO Settings']));
        }else{
            // Create an instance of ImageModifier
            $imageModifier = new ImageModifier();

            $ComOptionGet = ComOption::with('translations')
                ->whereIn('option_name', ['com_meta_title', 'com_meta_description', 'com_meta_tags','com_og_title', 'com_og_description'])
                ->get(['id']);

            // transformed data
            $transformedData = [];
            foreach ($ComOptionGet as $com_option) {
                $translations = $com_option->translations()->get()->groupBy('language');
                foreach ($translations as $language => $items) {
                    $languageInfo = ['language' => $language];
                    /* iterate all Column to Assign Language Value */
                    foreach ($this->get_com_option->translationKeys as $columnName) {
                        $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
                    }
                    $transformedData[] = $languageInfo;
                }
            }

            $com_meta_title = com_option_get('com_meta_title');
            $com_meta_description = com_option_get('com_meta_description');
            $com_meta_tags = com_option_get('com_meta_tags');
            $com_canonical_url = com_option_get('com_canonical_url');
            $com_og_title = com_option_get('com_og_title');
            $com_og_description = com_option_get('com_og_description');
            $com_og_image =com_option_get('com_og_image');
            $com_og_image_url = $imageModifier->generateImageUrl(com_option_get('com_og_image'));

            return $this->success([
                'com_meta_title' => $com_meta_title,
                'com_meta_description' => $com_meta_description,
                'com_meta_tags' => $com_meta_tags,
                'com_canonical_url' => $com_canonical_url,
                'com_og_title' => $com_og_title,
                'com_og_description' => $com_og_description,
                'com_og_image' => $com_og_image,
                'com_og_image_url' => $com_og_image_url,
                'translations' => $transformedData,
            ]);
        }

    }

    public function footerCustomization(Request $request){
        if ($request->isMethod('POST')) {
            $this->validate($request, [

                //Quick Access
                'com_quick_access' => 'nullable|array',
                'com_quick_access_enable_disable' => 'nullable|string',
                'com_quick_access.*.com_quick_access_title' => 'nullable|string',
                'com_quick_access.*.com_quick_access_name' => 'nullable|string',
                'com_quick_access.*.com_quick_access_url' => 'nullable|string',
                'com_quick_access.*.com_quick_access_icon' => 'nullable|string',
                'com_quick_access.*.com_quick_access_description' => 'nullable|string',
                'com_quick_access.*.com_quick_access_order' => 'nullable|integer',
                'com_quick_access.*.com_quick_access_target' => 'nullable|string|in:_self,_blank',

                //Categories
                'com_our_info_enable_disable' => 'nullable|string',
                'com_our_info_title' => 'nullable|string',
                'com_our_info_name' => 'nullable|string',
                'com_our_info_url' => 'nullable|string',

                // Categories (multiple entries)
                'com_our_info' => 'nullable|array',
                'com_our_info_enable_disable',              // General enable/disable for the section
                'com_our_info.*.title',                    // Title field for each entry
                'com_our_info.*.name',                     // Name field for each entry
                'com_our_info.*.url',                      // URL field for each entry

                // Social Links Section
                'com_social_links_facebook_url' => 'nullable|string',
                'com_social_links_twitter_url' => 'nullable|string',
                'com_social_links_instagram_url' => 'nullable|string',
                'com_social_links_linkedin_url' => 'nullable|string',
                'com_social_links_youtube_url' => 'nullable|string',
                'com_social_links_pinterest_url' => 'nullable|string',
                'com_social_links_snapchat_url' => 'nullable|string',

                // Download App Link Section
                'com_download_app_link_one' => 'nullable|string',
                'com_download_app_link_two' => 'nullable|string',

                // Accepted Payment Methods Section (multiple methods)
                'com_payment_methods' => 'nullable|array',
                'com_payment_methods.*.method' => 'nullable|string',
                'com_payment_methods.*.image' => 'nullable|string',
            ]);

            $fields = [
                // Quick Access
                'com_quick_access',
                'com_quick_access_enable_disable',
                'com_quick_access.*.com_quick_access_title',
                'com_quick_access.*.com_quick_access_name',
                'com_quick_access.*.com_quick_access_url',
                'com_quick_access.*.com_quick_access_icon',
                'com_quick_access.*.com_quick_access_description',
                'com_quick_access.*.com_quick_access_order',
                'com_quick_access.*.com_quick_access_target',

                // Categories (multiple entries)
                'com_our_info' => 'nullable|array',
                'com_our_info.*.title' => 'nullable|string',
                'com_our_info.*.name' => 'nullable|string',
                'com_our_info.*.url' => 'nullable|string',

                // Social Links Section
                'com_social_links_facebook_url',
                'com_social_links_twitter_url',
                'com_social_links_instagram_url',
                'com_social_links_linkedin_url',
                'com_social_links_youtube_url',
                'com_social_links_pinterest_url',
                'com_social_links_snapchat_url',

                // Download App Link Section
                'com_download_app_link_one',
                'com_download_app_link_two',

                // Accepted Payment Methods Section
                'com_payment_methods',
                'com_payment_methods.*.method',
                'com_payment_methods.*.image',
            ];

            foreach ($fields as $field) {

                  $value = $request->input($field) ?? null;
                  // if quick access is array store JSON
                    if(isset($request['data']['com_quick_access'])) {
                        $value = json_encode($request['data']['com_quick_access']);
                        if ($value !== false) { // Check if JSON encoding was successful
                            dd($value);
                            com_option_update('com_quick_access', $value);
                        }
                    }
//                    // Encode the array as a JSON string before storing
//                    if ($field == 'com_payment_methods' && is_array($value)) {
//                        $value = json_encode($value);
//                    }
//
//                    // Check if any of the com_our_info_* fields are arrays and encode as JSON if needed
//                    if (preg_match('/^com_our_info(\.\d+)?\.(title|name|url)$/', $field) && is_array($value)) {
//                        $value = json_encode($value);
//                    }

            }

            // Define the fields that need to be translated
            $fields = ['com_meta_title', 'com_meta_description', 'com_meta_tags','com_og_title', 'com_og_description'];
            $com_options = ComOption::whereIn('option_name', $fields)->get(['id']);

            foreach ($com_options as $com_option) {
                $this->transRepo->storeTranslation($request, $com_option->id, 'App\Models\ComOption', $this->translationKeys());
            }

            return $this->success(translate('messages.update_success', ['name' => 'Footer Settings']));
        }else{
            // Create an instance of ImageModifier
            $imageModifier = new ImageModifier();

            $ComOptionGet = ComOption::with('translations')
                ->whereIn('option_name', ['com_meta_title', 'com_meta_description', 'com_meta_tags','com_og_title', 'com_og_description'])
                ->get(['id']);

            // transformed data
            $transformedData = [];
            foreach ($ComOptionGet as $com_option) {
                $translations = $com_option->translations()->get()->groupBy('language');
                foreach ($translations as $language => $items) {
                    $languageInfo = ['language' => $language];
                    /* iterate all Column to Assign Language Value */
                    foreach ($this->get_com_option->translationKeys as $columnName) {
                        $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
                    }
                    $transformedData[] = $languageInfo;
                }
            }


            $responseData = [
                'com_quick_access' => com_option_get('com_quick_access') ?? [],
                'com_quick_access_enable_disable' => com_option_get('com_quick_access_enable_disable') ?? 'default_value',
                'com_our_info' => com_option_get('com_our_info') ?? [],
                'com_social_links_facebook_url' => com_option_get('com_social_links_facebook_url') ?? '',
                'com_social_links_twitter_url' => com_option_get('com_social_links_twitter_url') ?? '',
                'com_social_links_instagram_url' => com_option_get('com_social_links_instagram_url') ?? '',
                'com_social_links_linkedin_url' => com_option_get('com_social_links_linkedin_url') ?? '',
                'com_social_links_youtube_url' => com_option_get('com_social_links_youtube_url') ?? '',
                'com_social_links_pinterest_url' => com_option_get('com_social_links_pinterest_url') ?? '',
                'com_social_links_snapchat_url' => com_option_get('com_social_links_snapchat_url') ?? '',
                'com_download_app_link_one' => com_option_get('com_download_app_link_one') ?? '',
                'com_download_app_link_two' => com_option_get('com_download_app_link_two') ?? '',
                'com_payment_methods' => com_option_get('com_payment_methods') ?? [],
                'com_meta_title' => com_option_get('com_meta_title') ?? '',
                'com_meta_description' => com_option_get('com_meta_description') ?? '',
                'com_meta_tags' => com_option_get('com_meta_tags') ?? '',
                'com_canonical_url' => com_option_get('com_canonical_url') ?? '',
                'com_og_title' => com_option_get('com_og_title') ?? '',
                'com_og_description' => com_option_get('com_og_description') ?? '',
                'com_og_image' => com_option_get('com_og_image') ?? '',
            ];

// Ensure the OG image URL is only generated if `com_og_image` is not null
            if (!empty($responseData['com_og_image'])) {
                $responseData['com_og_image_url'] = $imageModifier->generateImageUrl($responseData['com_og_image']);
            } else {
                $responseData['com_og_image_url'] = ''; // Set to empty if no image URL is generated
            }

            return $this->success([
                'data' => $responseData,
                'translations' => $transformedData, // Assuming this is defined elsewhere in your code
            ]);
        }

    }

    public function maintenanceSettings(Request $request){
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'com_maintenance_title' => 'nullable|string',
                'com_maintenance_description' => 'nullable|string',
                'com_maintenance_start_date' => 'nullable|string',
                'com_maintenance_end_date' => 'nullable|string',
                'com_maintenance_image' => 'nullable|string',
            ]);

            $fields = ['com_maintenance_title', 'com_maintenance_description', 'com_maintenance_start_date', 'com_maintenance_end_date', 'com_maintenance_image'];
            foreach ($fields as $field) {
                  $value = $request->input($field) ?? null;
                  com_option_update($field, $value);
            }

            // Define the fields that need to be translated
            $fields = ['com_maintenance_title', 'com_maintenance_description'];
            $com_options = ComOption::whereIn('option_name', $fields)->get(['id']);

            foreach ($com_options as $com_option) {
                $this->transRepo->storeTranslation($request, $com_option->id, 'App\Models\ComOption', $this->translationKeys());
            }

            return $this->success(translate('messages.update_success', ['name' => 'Maintenance Settings']));
        }else{
            // Create an instance of ImageModifier
            $imageModifier = new ImageModifier();

            $ComOptionGet = ComOption::with('translations')
                ->whereIn('option_name', ['com_maintenance_title', 'com_maintenance_description'])
                ->get(['id']);

            // transformed data
            $transformedData = [];
            foreach ($ComOptionGet as $com_option) {
                $translations = $com_option->translations()->get()->groupBy('language');
                foreach ($translations as $language => $items) {
                    $languageInfo = ['language' => $language];
                    /* iterate all Column to Assign Language Value */
                    foreach ($this->get_com_option->translationKeys as $columnName) {
                        $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
                    }
                    $transformedData[] = $languageInfo;
                }
            }

            $com_maintenance_title = com_option_get('com_maintenance_title');
            $com_maintenance_description = com_option_get('com_maintenance_description');
            $com_maintenance_start_date = com_option_get('com_maintenance_start_date');
            $com_maintenance_end_date = com_option_get('com_maintenance_end_date');
            $com_maintenance_image = com_option_get('com_maintenance_image');
            $com_maintenance_image_url = $imageModifier->generateImageUrl(com_option_get('com_maintenance_image'));

            return $this->success([
                'com_maintenance_title' => $com_maintenance_title,
                'com_maintenance_description' => $com_maintenance_description,
                'com_maintenance_start_date' => $com_maintenance_start_date,
                'com_maintenance_end_date' => $com_maintenance_end_date,
                'com_maintenance_image' => $com_maintenance_image,
                'com_maintenance_image_url' => $com_maintenance_image_url,
                'translations' => $transformedData,
            ]);
        }

    }

    public function socialLoginSettings(Request $request){
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                // google
                'com_google_login_enabled' => 'nullable|string',
                'com_google_app_id' => 'nullable|string',
                'com_google_client_secret' => 'nullable|string',
                'com_google_client_callback_url' => 'nullable|string',
                // facebook
                'com_facebook_login_enabled' => 'nullable|string',
                'com_facebook_app_id' => 'nullable|string',
                'com_facebook_client_secret' => 'nullable|string',
                'com_facebook_client_callback_url' => 'nullable|string',
            ]);

            $fields = [
                'com_google_login_enabled',
                'com_google_app_id',
                'com_google_client_secret',
                'com_google_client_callback_url',
                'com_facebook_login_enabled',
                'com_facebook_app_id',
                'com_facebook_client_secret',
                'com_facebook_client_callback_url',
            ];

            foreach ($fields as $field) {
                  $value = $request->input($field) ?? null;
                  com_option_update($field, $value);
            }
            return $this->success(translate('messages.update_success', ['name' => 'Social Login Settings']));
        }else{
            // Retrieve the values using the correct keys
            $com_google_login_enabled = com_option_get('com_google_login_enabled');
            $com_google_app_id = com_option_get('com_google_app_id');
            $com_google_client_secret = com_option_get('com_google_client_secret');
            $com_google_client_callback_url = com_option_get('com_google_client_callback_url');

            $com_facebook_login_enabled = com_option_get('com_facebook_login_enabled');
            $com_facebook_app_id = com_option_get('com_facebook_app_id');
            $com_facebook_client_secret = com_option_get('com_facebook_client_secret');
            $com_facebook_client_callback_url = com_option_get('com_facebook_client_callback_url');

            return $this->success([
                'com_google_login_enabled' => $com_google_login_enabled,
                'com_google_app_id' => $com_google_app_id,
                'com_google_client_secret' => $com_google_client_secret,
                'com_google_client_callback_url' => $com_google_client_callback_url,
                'com_facebook_login_enabled' => $com_facebook_login_enabled,
                'com_facebook_app_id' => $com_facebook_app_id,
                'com_facebook_client_secret' => $com_facebook_client_secret,
                'com_facebook_client_callback_url' => $com_facebook_client_callback_url,
            ]);
        }

    }
}
