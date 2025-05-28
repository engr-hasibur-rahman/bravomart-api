<?php

namespace Modules\Chat\app\Http\Controllers\Api;

use App\Actions\ImageModifier;
use App\Http\Controllers\Controller;
use App\Models\SettingOption;
use Illuminate\Http\Request;

class AdminChatManageController extends Controller
{
    public function chatPusherSettings(Request $request)
    {
        if ($request->isMethod('POST')) {
            $validatedData = $request->validate([
                'com_pusher_app_id' => 'nullable|string',
                'com_pusher_app_key' => 'nullable|string',
                'com_pusher_app_secret' => 'nullable|string',
                'com_pusher_app_cluster' => 'nullable|max:255',
            ]);

            // Update settings
            $fields = [
                'com_pusher_app_id',
                'com_pusher_app_key',
                'com_pusher_app_secret',
                'com_pusher_app_cluster',
            ];

            foreach ($fields as $field) {
                com_option_update($field, $validatedData[$field] ?? null);
            }

            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Chat Settings']),
            ]);

        } else {
            return response()->json([
                'com_pusher_app_id' => com_option_get('com_pusher_app_id'),
                'com_pusher_app_key' => com_option_get('com_pusher_app_key'),
                'com_pusher_app_secret' => com_option_get('com_pusher_app_secret'),
                'com_pusher_app_cluster' => com_option_get('com_pusher_app_cluster')
            ]);
        }

    }
}
