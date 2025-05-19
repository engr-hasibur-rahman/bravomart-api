<?php

namespace App\Http\Controllers\Api\V1\Com;

use App\Actions\MultipleImageModifier;
use App\Http\Controllers\Controller;
use App\Http\Resources\Com\FooterInfoResource;
use App\Models\SettingOption;
use Illuminate\Http\Request;


class  HeaderFooterController extends Controller
{
    public function siteFooterInfo()
    {
        // Create an instance of ImageModifier
        $imageModifier = new MultipleImageModifier();
        // multiple image get
        $com_payment_methods_image_urls = $imageModifier->multipleImageModifier(com_option_get('com_payment_methods_image'));
        $ComOptionGet = SettingOption::with('translations')
            ->whereIn('option_name', ['com_meta_title', 'com_meta_description', 'com_meta_tags', 'com_og_title', 'com_og_description'])
            ->get();
        // transformed data
        $transformedData = [];
        foreach ($ComOptionGet as $com_option) {
            $translations = $com_option->translations()->get()->groupBy('language');
            foreach ($translations as $language => $items) {
                $languageInfo = ['language' => $language];
                /* iterate all Column to Assign Language Value */
                foreach ($com_option->translationKeys as $columnName) {
                    $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
                }
                $transformedData[] = $languageInfo;
            }
        }

        $footer_info[] = [
            'com_quick_access' => json_decode(com_option_get('com_quick_access'), true) ?? [],
            'com_our_info' => json_decode(com_option_get('com_our_info'), true) ?? [],
            'com_help_center' => json_decode(com_option_get('com_help_center'), true) ?? [],
            'com_quick_access_enable_disable' => com_option_get('com_quick_access_enable_disable') ?? '',
            'com_help_center_enable_disable' => com_option_get('com_quick_access_enable_disable') ?? '',
            'com_our_info_enable_disable' => com_option_get('com_our_info_enable_disable') ?? '',
            'com_quick_access_title' => com_option_get('com_quick_access_title') ?? '',
            'com_our_info_title' => com_option_get('com_our_info_title') ?? '',
            'com_help_center_title' => com_option_get('com_our_info_title') ?? '',
            'com_social_links_enable_disable' => com_option_get('com_social_links_enable_disable') ?? '',
            'com_social_links_title' => com_option_get('com_social_links_title') ?? '',
            'com_social_links_facebook_url' => com_option_get('com_social_links_facebook_url') ?? '',
            'com_social_links_twitter_url' => com_option_get('com_social_links_twitter_url') ?? '',
            'com_social_links_instagram_url' => com_option_get('com_social_links_instagram_url') ?? '',
            'com_social_links_linkedin_url' => com_option_get('com_social_links_linkedin_url') ?? '',
            'com_social_links_youtube_url' => com_option_get('com_social_links_youtube_url') ?? '',
            'com_social_links_pinterest_url' => com_option_get('com_social_links_pinterest_url') ?? '',
            'com_social_links_snapchat_url' => com_option_get('com_social_links_snapchat_url') ?? '',
            'com_download_app_link_one' => com_option_get('com_download_app_link_one') ?? '',
            'com_download_app_link_two' => com_option_get('com_download_app_link_two') ?? '',
            'com_payment_methods_enable_disable' => com_option_get('com_payment_methods_enable_disable') ?? '',
            'com_payment_methods_image' => com_option_get('com_payment_methods_image') ?? '',
            'com_payment_methods_image_urls' => $com_payment_methods_image_urls ?? '',
            'translations' => $transformedData,
        ];

        return response()->json([
            'data' => new FooterInfoResource($footer_info),
        ]);
    }
}
