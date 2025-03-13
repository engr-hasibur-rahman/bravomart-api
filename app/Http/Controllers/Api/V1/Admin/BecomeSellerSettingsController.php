<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminBecomeSellerResource;
use App\Models\BecomeSellerSetting;
use App\Models\Translation;
use Illuminate\Http\Request;

class BecomeSellerSettingsController extends Controller
{
    public function __construct(protected BecomeSellerSetting $becomeSellerSetting, protected Translation $translation)
    {

    }

    public function translationKeys(): mixed
    {
        return $this->becomeSellerSetting->translationKeys;
    }

    public function becomeSellerSettings(Request $request)
    {
        if ($request->isMethod('GET')) {
            $settings = BecomeSellerSetting::with('related_translations')->where('status', 1)->first();
            if (!$settings) {
                return response()->json([
                    'message' => __('messages.data_not_found')
                ],404);
            }
            $content = jsonImageModifierFormatter($settings->content);
            $settings->content = $content;
            return response()->json([
                'data' => new AdminBecomeSellerResource($settings),
            ]);
        }
        $validatedData = $request->validate([
            'content' => 'required|array'
        ]);
        $settings = BecomeSellerSetting::updateOrCreate(
            ['id' => $request->id],
            ['content' => $validatedData['content']]
        );
        $this->createOrUpdateTranslation($request, $settings->id, 'App\Models\BecomeSellerSetting', $this->translationKeys());

        return response()->json([
            'success' => true,
            'message' => 'Settings saved successfully',
            'data' => $settings
        ]);
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
