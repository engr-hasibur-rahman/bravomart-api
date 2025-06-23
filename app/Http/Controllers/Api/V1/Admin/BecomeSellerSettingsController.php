<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\Controller;
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

        createOrUpdateTranslationJson($request, $settings->id, 'App\Models\BecomeSellerSetting', $this->translationKeys());

        return response()->json([
            'success' => true,
            'message' => 'Settings saved successfully',
            'data' => $settings
        ]);
    }

    private function createOrUpdateTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
    {
        if (empty($request['translations'])) {
            return false;
        }

        $requestedLanguages = array_column($request['translations'], 'language_code');

        // Delete translations for languages not present in the request
        $this->translation->where('translatable_type', $refPath)
            ->where('translatable_id', $refid)
            ->whereNotIn('language', $requestedLanguages)
            ->delete();

        $translations = [];
        foreach ($request['translations'] as $translation) {
            foreach ($colNames as $key) {
                $translatedValue = $translation[$key] ?? null;

                if ($translatedValue === null) {
                    continue;
                }

                $trans = $this->translation
                    ->where('translatable_type', $refPath)
                    ->where('translatable_id', $refid)
                    ->where('language', $translation['language_code'])
                    ->where('key', $key)
                    ->first();

                if ($trans) {
                    $trans->value = $translatedValue;
                    $trans->save();
                } else {
                    $translations[] = [
                        'translatable_type' => $refPath,
                        'translatable_id' => $refid,
                        'language' => $translation['language_code'],
                        'key' => $key,
                        'value' => $translatedValue,
                    ];
                }
            }
        }

        if (!empty($translations)) {
            $this->translation->insert($translations);
        }

        return true;
    }
}
