<?php

namespace Modules\SmsGateway\app\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Controller;
use App\Models\Customer;
use App\Models\DeliveryMan;
use App\Models\SettingOption;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\SmsGateway\app\Models\UserOtp;
use Modules\SmsGateway\app\Services\Sms\SmsManager;
use Symfony\Component\HttpFoundation\Response;

class UserOtpController extends Controller
{
    /**
     * @throws \Exception
     */

    public function __construct()
    {
        $setting_options = SettingOption::where('option_name', 'otp_login_enabled_disable')->value('option_value');
        if (empty($setting_options) || $setting_options === 'off') {
            throw new HttpResponseException(response()->json([
                'message' => __('messages.setting_disabled', ['name' => 'Otp login']),
            ], Response::HTTP_UNPROCESSABLE_ENTITY));
        }
    }

    public function sendOtp(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'user_type' => 'required|string|in:customer,deliveryman',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $otp = rand(100000, 999999);
        $success = SmsManager::send($request->phone, $otp);

        if (!$success) {
            return response()->json([
                'message' => __('massages.send_failed', ['name' => 'Otp'])
            ], 500);
        }

        $userId = null;

        switch ($request->user_type) {
            case 'customer':
                $customer = Customer::firstOrCreate(['phone' => $request->phone]);
                $userId = $customer->id;
                break;

            case 'deliveryman':
                $deliveryMan = User::firstOrCreate([
                    'phone' => $request->phone,
                    'activity_scope' => 'delivery_level',
                    'store_owner' => 0
                ]);
                DeliveryMan::firstOrCreate([
                    'user_id' => $deliveryMan->id,
                ]);
                $userId = $deliveryMan->id;
                break;

            default:
                $user = User::firstOrCreate(['phone' => $request->phone]);
                $userId = $user->id;
        }

        UserOtp::create([
            'user_id' => $userId,
            'user_type' => $request->user_type,
            'otp_code' => $otp,
            'expired_at' => SmsManager::getExpireAt()
        ]);

        return response()->json([
            'message' => __('massages.send_success', ['name' => 'Otp']),
        ]);
    }

    public function verifyOtp(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'otp' => 'required|string',
            'user_type' => 'required|string|in:customer,deliveryman',
            'firebase_device_token' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = match ($request->user_type) {
            'customer' => Customer::where('phone', $request->phone)->first(),
            'deliveryman' => User::where([
                'phone' => $request->phone,
                'activity_scope' => 'delivery_level',
                'store_owner' => 0
            ])->first(),
            default => null,
        };

        if (!$user) {
            return response()->json([
                'message' => __('messages.data_not_found'),
            ], Response::HTTP_NOT_FOUND);
        }

        $otp = UserOtp::where('user_id', $user->id)
            ->where('user_type', $request->user_type)
            ->where('otp_code', $request->otp)
            ->latest()
            ->first();

        if (!$otp) {
            return response()->json([
                'message' => __('messages.verification_failed', ['name' => 'Otp']),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($otp->expired_at < now()) {
            return response()->json([
                'message' => __('messages.expired', ['name' => 'Otp']),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $otp->delete();
//         update firebase device token
        $user->update([
            'firebase_token' => $request->firebase_device_token,
        ]);

        if ($request->user_type === 'deliveryman') {
            // Check if the user's email is verified
            $email_verified = $user->hasVerifiedEmail();

            // Fetch permissions
            $permissions = $user->rolePermissionsQuery()
                ->whereNull('parent_id')
                ->with('childrenRecursive')
                ->get();

            // Build and return the response
            return response()->json([
                "status" => true,
                "status_code" => 200,
                "message" => __('messages.login_success', ['name' => 'Deliveryman']),
                "token" => $user->createToken('auth_token')->plainTextToken,
                "deliveryman_id" => $user->id,
                "email_verified" => $email_verified,
                "activity_notification" => (bool)$user->activity_notification,
                "account_status" => $user->deactivated_at ? 'deactivated' : 'active',
                "role" => $user->getRoleNames()->first(),
            ], 200);
        }

        return response()->json([
            "status" => true,
            "status_code" => 200,
            "message" => __('messages.login_success', ['name' => 'Customer']),
            "token" => $user->createToken('customer_auth_token')->plainTextToken,
            "email_verified" => (bool)$user->email_verified, // shorthand of -> $token->email_verified ? true : false
            "account_status" => $user->deactivated_at ? 'deactivated' : 'active',
            "marketing_email" => (bool)$user->marketing_email,
            "activity_notification" => (bool)$user->activity_notification,
        ]);
    }


    public function resendOtp(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'user_type' => 'required|string|in:customer,deliveryman',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Find existing user by type
        $user = match ($request->user_type) {
            'customer' => Customer::where('phone', $request->phone)->first(),
            'deliveryman' => User::where([
                'phone' => $request->phone,
                'activity_scope' => 'delivery_level',
                'store_owner' => 0
            ])->first(),
            default => null,
        };

        if (!$user) {
            return response()->json([
                'message' => __('messages.data_not_found'),
            ], Response::HTTP_NOT_FOUND);
        }

        // Check latest OTP created within last 60 seconds
        $lastOtp = UserOtp::where('user_id', $user->id)
            ->where('user_type', $request->user_type)
            ->latest()
            ->first();

        if ($lastOtp && $lastOtp->created_at > now()->subSeconds(60)) {
            $remaining = 60 - now()->diffInSeconds($lastOtp->created_at);
            return response()->json([
                'message' => __('messages.resend_wait', ['seconds' => $remaining]),
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        // Generate and send new OTP
        $otp = rand(100000, 999999);
        $success = SmsManager::send($request->phone, $otp);

        if (!$success) {
            return response()->json([
                'message' => __('messages.send_failed', ['name' => 'Otp']),
            ], 500);
        }

        if (!$lastOtp) {
            return response()->json([
                'message' => __('messages.send_first', ['name' => 'Otp']),
            ]);
        }

        // Save new OTP
        UserOtp::where('user_id', $user->id)->update(
            [
                'user_type' => $request->user_type,
                'otp_code' => $otp,
                'expired_at' => SmsManager::getExpireAt(),
            ]);

        return response()->json([
            'message' => __('messages.send_success', ['name' => 'Otp']),
        ]);
    }

}
