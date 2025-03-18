<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Actions\ImageModifier;
use App\Http\Controllers\Controller;
use App\Interfaces\TranslationInterface;
use App\Models\SettingOption;
use App\Models\Translation;
use Illuminate\Http\Request;

class PageSettingsManageController extends Controller
{

    public function __construct(
        protected Translation   $translation,
        protected SettingOption $get_com_option,
    )
    {
    }

    public function translationKeys(): mixed
    {
        return $this->get_com_option->translationKeys;
    }

    public function registerSettings(Request $request)
    {
        if ($request->isMethod('POST')) {
//            // check options
//            $this->validate($request, [
//                'com_register_page_title' => 'nullable|string',
//                'com_register_page_subtitle' => 'nullable|string',
//                'com_register_page_description' => 'nullable|string',
//                'com_register_page_image' => 'nullable|max:255',
//                'com_register_page_terms_page' => 'nullable|string',
//                'com_register_page_terms_title' => 'nullable|string',
//                'com_register_page_social_enable_disable' => 'nullable|string',
//            ]);
//
//            // set options
//            $fields = [
//                'com_register_page_title',
//                'com_register_page_subtitle',
//                'com_register_page_description',
//                'com_register_page_image',
//                'com_register_page_terms_page',
//                'com_register_page_terms_title',
//                'com_register_page_social_enable_disable',
//            ];
//
//            // update options
//            foreach ($fields as $field) {
//                $value = $request->input($field) ?? null;
//                com_option_update($field, $value);
//            }
//
//            // Define the fields that need to be translated
//            $fields = [
//                'com_register_page_title',
//                'com_register_page_subtitle',
//                'com_register_page_description',
//                'com_register_page_terms_title',
//            ];
//            $setting_options = SettingOption::whereIn('option_name', $fields)->get();
//
//            foreach ($setting_options as $com_option) {
//                $this->transRepo->storeTranslation($request, $com_option->id, 'App\Models\SettingOption', [$com_option->option_name]);
//            }
//            return $this->success(translate('messages.update_success', ['name' => 'Register Page Settings']));
            $validatedData = $request->validate([
                'com_register_page_title' => 'nullable|string',
                'com_register_page_subtitle' => 'nullable|string',
                'com_register_page_description' => 'nullable|string',
                'com_register_page_image' => 'nullable|max:255',
                'com_register_page_terms_page' => 'nullable|string',
                'com_register_page_terms_title' => 'nullable|string',
                'com_register_page_social_enable_disable' => 'nullable|string',
                'translations' => 'nullable|array',
            ]);

            // Update settings in DB
            $fields = [
                'com_register_page_title',
                'com_register_page_subtitle',
                'com_register_page_description',
                'com_register_page_image',
                'com_register_page_terms_page',
                'com_register_page_terms_title',
                'com_register_page_social_enable_disable',
            ];

            foreach ($fields as $field) {
                com_option_update($field, $validatedData[$field] ?? null);
            }

            // Handle translations
            $settingOptions = SettingOption::whereIn('option_name', [
                'com_register_page_title', 'com_register_page_subtitle',
                'com_register_page_description', 'com_register_page_terms_title'
            ])->pluck('id', 'option_name');

            foreach ($settingOptions as $optionName => $optionId) {
                $this->createOrUpdateTranslation($request, $optionId, 'App\Models\SettingOption', [$optionName]);
            }

            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Register Page Settings']),
            ]);

        } else {
            // Create an instance of ImageModifier
            $imageModifier = new ImageModifier();

            $ComOptionGet = SettingOption::with('related_translations')
                ->whereIn('option_name', ['com_register_page_title', 'com_register_page_subtitle', 'com_register_page_description', 'com_register_page_terms_title'])
                ->get(['id']);
            $translations = $ComOptionGet->flatMap(function ($settingOption) {
                return $settingOption->related_translations->map(function ($translation) {
                    return [
                        'language' => $translation->language,
                        'key' => $translation->key,
                        'value' => trim($translation->value, '"'), // Removes extra quotes
                    ];
                });
            })->groupBy('language')->map(function ($items, $language) {
                return array_merge(
                    ['language_code' => $language],
                    $items->pluck('value', 'key')->toArray()
                );
            })->toArray();

//            // transformed data
//            $transformedData = [];
//            foreach ($ComOptionGet as $com_option) {
//                $translations = $com_option->translations()->get()->groupBy('language');
//                foreach ($translations as $language => $items) {
//                    $languageInfo = ['language' => $language];
//                    /* iterate all Column to Assign Language Value */
//                    foreach ($this->get_com_option->translationKeys as $columnName) {
//                        $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
//                    }
//                    $transformedData[] = $languageInfo;
//                }
//            }

            $fields = [
                'com_register_page_title' => com_option_get('com_register_page_title'),
                'com_register_page_subtitle' => com_option_get('com_register_page_subtitle'),
                'com_register_page_description' => com_option_get('com_register_page_description'),
                'com_register_page_image' => com_option_get('com_register_page_image'),
                'com_register_page_image_url' => $imageModifier->generateImageUrl(com_option_get('com_register_page_image')),
                'com_register_page_terms_page' => com_option_get('com_register_page_terms_page'),
                'com_register_page_terms_title' => com_option_get('com_register_page_terms_title'),
                'com_register_page_social_enable_disable' => com_option_get('com_register_page_social_enable_disable'),
                'translations' => $translations
            ];

            return response()->json([
                'data' => $fields,
            ]);
        }

    }

    public function loginSettings(Request $request)
    {
        if ($request->isMethod('POST')) {
            // check options
            $validatedData = $request->validate([
                'com_login_page_title' => 'nullable|string',
                'com_login_page_subtitle' => 'nullable|string',
                'com_login_page_image' => 'nullable|max:255',
                'com_login_page_social_enable_disable' => 'nullable|string',
            ]);

            // set options
            $fields = [
                'com_login_page_title',
                'com_login_page_subtitle',
                'com_login_page_image',
                'com_login_page_social_enable_disable',
            ];

            // update options
            foreach ($fields as $field) {
                com_option_update($field, $validatedData[$field] ?? null);
            }

            // Handle translations
            $settingOptions = SettingOption::whereIn('option_name', [
                'com_login_page_title', 'com_login_page_subtitle'
            ])->pluck('id', 'option_name');

            foreach ($settingOptions as $optionName => $optionId) {
                $this->createOrUpdateTranslation($request, $optionId, 'App\Models\SettingOption', [$optionName]);
            }

            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Login Page Settings']),
            ]);

        } else {
            // ImageModifier
            $imageModifier = new ImageModifier();
            $ComOptionGet = SettingOption::with('translations')
                ->whereIn('option_name', ['com_login_page_title', 'com_login_page_subtitle'])
                ->get(['id']);

            $translations = $ComOptionGet->flatMap(function ($settingOption) {
                return $settingOption->related_translations->map(function ($translation) {
                    return [
                        'language' => $translation->language,
                        'key' => $translation->key,
                        'value' => trim($translation->value, '"'), // Removes extra quotes
                    ];
                });
            })->groupBy('language')->map(function ($items, $language) {
                return array_merge(
                    ['language_code' => $language],
                    $items->pluck('value', 'key')->toArray()
                );
            })->toArray();

            $fields = [
                'com_login_page_title' => com_option_get('com_login_page_title'),
                'com_login_page_subtitle' => com_option_get('com_login_page_subtitle'),
                'com_login_page_image' => com_option_get('com_login_page_image'),
                'com_login_page_image_url' => $imageModifier->generateImageUrl(com_option_get('com_login_page_image')),
                'com_login_page_social_enable_disable' => com_option_get('com_login_page_social_enable_disable'),
                'translations' => $translations,
            ];

            return response()->json([
                'data' => $fields,
            ]);
        }
    }

    public function ProductDetailsSettings(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                // fee delivery
                'com_product_details_page_delivery_title' => 'nullable|string',
                'com_product_details_page_delivery_subtitle' => 'nullable|string',
                'com_product_details_page_delivery_url' => 'nullable|string',
                'com_product_details_page_delivery_enable_disable' => 'nullable|string',
                // return and refund
                'com_product_details_page_return_refund_title' => 'nullable|string',
                'com_product_details_page_return_refund_subtitle' => 'nullable|string',
                'com_product_details_page_return_refund_url' => 'nullable|string',
                'com_product_details_page_return_refund_enable_disable' => 'nullable|string',
                // other
                'com_product_details_page_related_title' => 'nullable|string',
            ]);

            // set options
            $fields = [
                'com_product_details_page_delivery_title',
                'com_product_details_page_delivery_subtitle',
                'com_product_details_page_delivery_url',
                'com_product_details_page_delivery_enable_disable',
                'com_product_details_page_return_refund_title',
                'com_product_details_page_return_refund_subtitle',
                'com_product_details_page_return_refund_url',
                'com_product_details_page_return_refund_enable_disable',
                'com_product_details_page_related_title',
            ];

            // update options
            foreach ($fields as $field) {
                $value = $request->input($field) ?? null;
                com_option_update($field, $value);
            }

            // Define the fields that need to be translated
            $fields = [
                'com_product_details_page_delivery_title',
                'com_product_details_page_delivery_subtitle',
                'com_product_details_page_return_refund_title',
                'com_product_details_page_return_refund_subtitle',
            ];
            $setting_options = SettingOption::whereIn('option_name', $fields)->get();

            foreach ($setting_options as $com_option) {
                $this->transRepo->storeTranslation($request, $com_option->id, 'App\Models\SettingOption', [$com_option->option_name]);
            }
            return $this->success(translate('messages.update_success', ['name' => 'Product Details Page Settings']));

        } else {
            $ComOptionGet = SettingOption::with('translations')
                ->whereIn('option_name', [
                    'com_product_details_page_delivery_title',
                    'com_product_details_page_delivery_subtitle',
                    'com_product_details_page_return_refund_title',
                    'com_product_details_page_return_refund_subtitle',
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

            $fields = [
                'com_product_details_page_delivery_title' => com_option_get('com_product_details_page_delivery_title'),
                'com_product_details_page_delivery_subtitle' => com_option_get('com_product_details_page_delivery_subtitle'),
                'com_product_details_page_delivery_url' => com_option_get('com_product_details_page_delivery_url'),
                'com_product_details_page_delivery_enable_disable' => com_option_get('com_product_details_page_delivery_enable_disable'),
                'com_product_details_page_return_refund_title' => com_option_get('com_product_details_page_return_refund_title'),
                'com_product_details_page_return_refund_subtitle' => com_option_get('com_product_details_page_return_refund_subtitle'),
                'com_product_details_page_return_refund_url' => com_option_get('com_product_details_page_return_refund_url'),
                'com_product_details_page_return_refund_enable_disable' => com_option_get('com_product_details_page_return_refund_enable_disable'),
                'com_product_details_page_related_title' => com_option_get('com_product_details_page_related_title'),
                'translations' => $transformedData,
            ];

            return response()->json([
                'data' => $fields,
            ]);
        }

    }

    private function createOrUpdateTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
    {
        if (empty($request['translations'])) {
            return false;  // Return false if no translations are provided
        }

        $translations = [];
        foreach ($request['translations'] as $translation) {
            foreach ($colNames as $key) {
                // Fallback value if translation key does not exist
                $translatedValue = $translation[$key] ?? null;

                // Skip translation if the value is NULL
                if ($translatedValue === null) {
                    continue; // Skip this field if it's NULL
                }

                // Check if a translation exists for the given reference path, ID, language, and key
                $trans = $this->translation
                    ->where('translatable_type', $refPath)
                    ->where('translatable_id', $refid)
                    ->where('language', $translation['language_code'])
                    ->where('key', $key)
                    ->first();

                if ($trans) {
                    // Update the existing translation
                    $trans->value = $translatedValue;
                    $trans->save();
                } else {
                    // Prepare new translation entry for insertion
                    $translations[] = [
                        'translatable_type' => $refPath,
                        'translatable_id' => $refid,
                        'language' => $translation['language_code'],
                        'key' => $key,
                        'value' => json_encode($translatedValue, JSON_UNESCAPED_UNICODE),
                    ];
                }
            }
        }
        // Insert new translations if any
        if (!empty($translations)) {
            $this->translation->insert($translations);
        }
        return true;
    }
}
