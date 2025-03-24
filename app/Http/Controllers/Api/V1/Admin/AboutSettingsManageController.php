<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminAboutSettingsResource;
use App\Models\AboutSetting;
use App\Models\Translation;
use Illuminate\Http\Request;

class AboutSettingsManageController extends Controller
{
    public function __construct(protected AboutSetting $aboutSetting, protected Translation $translation)
    {

    }

    public function translationKeys(): mixed
    {
        return $this->aboutSetting->translationKeys;
    }

    public function aboutSettings(Request $request)
    {
        if ($request->isMethod('GET')) {
            $settings = AboutSetting::with('related_translations')->where('status', 1)->first();
            if (!$settings) {
                return response()->json([
                    'message' => __('messages.data_not_found')
                ], 404);
            }
            $content = jsonImageModifierFormatter($settings->content);
            $settings->content = $content;
            return response()->json([
                'data' => new AdminAboutSettingsResource($settings),
            ]);
        }
        $validatedData = $request->validate([
            'content' => 'required|array'
        ]);
        $settings = AboutSetting::updateOrCreate(
            ['id' => $request->id],
            ['content' => $validatedData['content']]
        );
        createOrUpdateTranslation($request, $settings->id, 'App\Models\AboutSetting', $this->translationKeys());

        return response()->json([
            'success' => true,
            'message' => 'Settings saved successfully',
            'data' => $settings
        ]);
    }
}
