<?php

namespace App\Http\Controllers\Api\V1\Com;

use App\Actions\ImageModifier;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuPublicViewResource;
use App\Interfaces\TranslationInterface;
use App\Models\Menu;
use App\Models\SettingOption;
use Illuminate\Http\Request;

class FrontendPageSettingsController extends Controller
{

    public function __construct(
        protected TranslationInterface $transRepo,
        protected SettingOption        $get_com_option,
    ) {}

    public function translationKeys(): mixed
    {
        return $this->get_com_option->translationKeys;
    }

    public function RegisterPageSettings(){
        $ComOptionGet = SettingOption::with('translations')
            ->whereIn('option_name', [
                'com_register_page_title',
                'com_register_page_subtitle',
                'com_register_page_description',
                'com_register_page_terms_title',
            ])->get(['id']);

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

        $page_settings[] = [
            'com_register_page_title' => com_option_get('com_register_page_title') ?? '',
            'com_register_page_subtitle' => com_option_get('com_register_page_subtitle') ?? '',
            'com_register_page_description' => com_option_get('com_register_page_description') ?? '',
            'com_register_page_image' => ImageModifier::generateImageUrl(com_option_get('com_register_page_description')),
            'com_register_page_terms_page' => com_option_get('com_register_page_terms_page'),
            'com_register_page_terms_title' => com_option_get('com_register_page_terms_title'),
            'com_register_page_social_enable_disable' => com_option_get('com_register_page_social_enable_disable'),
            'translations' => $transformedData,
        ];

        return response()->json([
            'data' => $page_settings
        ]);
    }

    public function LoginPageSettings(){
        $ComOptionGet = SettingOption::with('translations')
            ->whereIn('option_name', [
                'com_login_page_title',
                'com_login_page_subtitle',
            ])->get(['id']);

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

        $page_settings[] = [
            'com_login_page_title' => com_option_get('com_login_page_title') ?? '',
            'com_login_page_subtitle' => com_option_get('com_login_page_subtitle') ?? '',
            'com_login_page_social_enable_disable' => com_option_get('com_login_page_social_enable_disable'),
            'com_login_page_image' => ImageModifier::generateImageUrl(com_option_get('com_login_page_image')),
            'translations' => $transformedData,
        ];

        return response()->json([
            'data' => $page_settings
        ]);
    }

    public function productDetailsPageSettings(){

        $ComOptionGet = SettingOption::with('translations')->whereIn('option_name', [
                'com_product_details_page_delivery_title',
                'com_product_details_page_delivery_subtitle',
                'com_product_details_page_return_refund_title',
                'com_product_details_page_return_refund_subtitle',
                'com_product_details_page_related_title'
            ])->get(['id']);

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

        $page_settings[] = [
            'com_product_details_page_delivery_title' => com_option_get('com_product_details_page_delivery_title') ?? '',
            'com_product_details_page_delivery_subtitle' => com_option_get('com_product_details_page_delivery_subtitle') ?? '',
            'com_product_details_page_delivery_url' => com_option_get('com_product_details_page_delivery_url') ?? '',
            'com_product_details_page_delivery_enable_disable' => com_option_get('com_product_details_page_delivery_enable_disable') ?? '',
            'com_product_details_page_return_refund_title' => com_option_get('com_product_details_page_return_refund_title') ?? '',
            'com_product_details_page_return_refund_subtitle' => com_option_get('com_product_details_page_return_refund_subtitle') ?? '',
            'com_product_details_page_return_refund_url' => com_option_get('com_product_details_page_return_refund_url') ?? '',
            'com_product_details_page_return_refund_enable_disable' => com_option_get('com_product_details_page_return_refund_enable_disable') ?? '',
            'com_product_details_page_related_title' => com_option_get('com_product_details_page_related_title') ?? '',
            'translations' => $transformedData,
        ];

        return response()->json([
            'data' => $page_settings
        ]);
    }

    public function BlogPageSettings(){

        $ComOptionGet = SettingOption::with('translations')->whereIn('option_name', [
                'com_login_page_title',
                'com_login_page_subtitle',
                'com_login_page_image',
                'com_login_page_social_enable_disable',
            ])->get(['id']);

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

        $page_settings[] = [
            'com_login_page_title' => com_option_get('com_login_page_title') ?? '',
            'com_login_page_subtitle' => com_option_get('com_login_page_subtitle') ?? '',
            'com_login_page_social_enable_disable' => com_option_get('com_login_page_social_enable_disable') ?? '',
            'com_login_page_image' => ImageModifier::generateImageUrl(com_option_get('com_login_page_image')),
            'translations' => $transformedData,
        ];

        return response()->json([
            'data' => $page_settings
        ]);
    }


    public function menuOptionSettings(){
        $menus = Menu::where('is_visible', true)
            ->orderBy('position')
            ->get();
        return response()->json([
            'menus' => MenuPublicViewResource::collection($menus),
        ]);
    }




}