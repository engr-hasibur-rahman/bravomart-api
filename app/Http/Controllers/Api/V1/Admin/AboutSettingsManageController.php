<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Resources\Admin\AdminAboutSettingsResource;
use App\Models\Page;
use App\Models\Translation;
use Illuminate\Http\Request;

class AboutSettingsManageController extends Controller
{
    public function __construct(protected Page $aboutSetting, protected Translation $translation)
    {

    }

    public function translationKeys(): mixed
    {
        return $this->aboutSetting->translationKeys;
    }

    public function aboutSettings(Request $request)
    {
        if ($request->isMethod('GET')) {
            $settings = Page::with('related_translations')
                ->where('slug', 'about_page')
                ->first();

            if (!$settings) {
                return response()->json([
                    'message' => __('messages.data_not_found')
                ], 404);
            }

            $content = $settings->content ? json_decode($settings->content, true) : [];
            $content = is_array($content) ? jsonImageModifierFormatter($content) : [];
            $settings->content = $content;

            return response()->json([
                'data' => new AdminAboutSettingsResource($settings),
            ]);
        }

        $validatedData = $request->validate([
            'content' => 'required|array',
            'translations' => 'required|array',
        ]);

        // Update by ID
        $settings = Page::where('slug', 'about_page')->first();

        if ($settings) {
            $settings->update([
                'content' => json_encode($validatedData['content']),
                'title' => 'About Page',
            ]);
        } else {
            $settings = Page::updateOrCreate(
                ['slug' => 'about_page'],
                [
                    'content' => json_encode($validatedData['content']),
                    'title' => 'About Page',
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
}
