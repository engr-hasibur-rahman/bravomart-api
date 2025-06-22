<?php

namespace Modules\SmsGateway\app\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\SmsGateway\app\Models\SmsProvider;

class SmsProviderController extends Controller
{
    public function smsProviderSettingUpdate(Request $request){
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|in:nexmo,twilio',
                    'expire_time' => 'required|numeric',
                    'nexmo_api_key' => 'required_if:sms_provider_name,nexmo',
                    'nexmo_api_secret' => 'required_if:sms_provider_name,nexmo',
                    'twilio_sid' => 'required_if:sms_provider_name,twilio',
                    'twilio_auth_key' => 'required_if:sms_provider_name,twilio',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ], 422);
                }

                // Save logic example
                $credentials = [];

                if ($request->name === 'nexmo') {
                    $credentials = [
                        'api_key' => $request->nexmo_api_key,
                        'api_secret' => $request->nexmo_api_secret,
                    ];
                }

                if ($request->name === 'twilio') {
                    $credentials = [
                        'sid' => $request->twilio_sid,
                        'auth_key' => $request->twilio_auth_key,
                    ];
                }

             SmsProvider::updateOrCreate(
                    ['slug' => $request->name],
                    [
                        'name' => ucfirst($request->name),
                        'slug' => $request->name,
                        'expire_time' => $request->expire_time,
                        'credentials' => json_encode($credentials),
                        'status' => 1,
                    ]
                );

                return response()->json([
                    'status' => true,
                    'message' => 'SMS Provider updated successfully.',
                ]);

    }

    public function smsProviderStatusUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|in:nexmo,twilio',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Deactivate all providers
        SmsProvider::query()->update(['status' => 0]);

        // Activate the selected one
        $smsProvider = SmsProvider::where('name', $request->name)->first();

        if ($smsProvider) {
            $smsProvider->update(['status' => 1]);

            return response()->json([
                'status' => true,
                'message' => 'SMS Provider activated successfully.',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'SMS Provider not found.',
        ], 404);

    }

}
