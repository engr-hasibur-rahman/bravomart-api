<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Resources\Admin\AdminBecomeSellerResource;
use App\Models\Page;
use App\Models\Translation;
use Illuminate\Http\Request;

class BecomeSellerSettingsController extends Controller
{
    public function __construct(protected Page $becomeSellerSetting, protected Translation $translation)
    {

    }

    public function translationKeys(): mixed
    {
        return $this->becomeSellerSetting->translationKeys;
    }

    public function becomeSellerSettings(Request $request)
    {
        if ($request->isMethod('GET')) {
            $settings = Page::with('related_translations')
                ->where('slug', 'become_seller')
                ->first();

            if (!$settings) {
                return response()->json([
                    'message' => __('messages.data_not_found')
                ],404);
            }

            $content = $settings->content ? json_decode($settings->content, true) : [];
            $content = is_array($content) ? jsonImageModifierFormatter($content) : [];
            $settings->content = $content;

            return response()->json([
                'data' => new AdminBecomeSellerResource($settings),
            ]);
        }

        $validatedData = $request->validate([
            'content' => 'required|array',
            'translations' => 'required|array',
        ]);

        // Update by ID
        $settings = Page::where('slug', 'become_seller')->first();

        if ($settings) {
            $settings->update([
                'content' => json_encode($validatedData['content']),
                'title' => 'Become A Seller',
            ]);
        } else {
            $settings = Page::updateOrCreate(
                ['slug' => 'become_seller'],
                [
                    'content' => json_encode($validatedData['content']),
                    'title' => 'Become A Seller',
                    'status' => 'publish',
                ]
            );
        }

        foreach ($validatedData['translations'] as $translation) {
            Translation::updateOrCreate(
                [
                    'language' => $translation['language_code'],
                    'translatable_id' => $settings->id,
                    'translatable_type' => 'App\Models\Page',
                    'key' => 'content',
                ],
                [
                    'value' => json_encode($translation['content']),
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings saved successfully',
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
