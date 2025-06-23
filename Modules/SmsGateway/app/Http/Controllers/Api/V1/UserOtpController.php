<?php

namespace Modules\SmsGateway\app\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Services\Sms\SmsManager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\SmsGateway\app\Models\UserOtp;
use Symfony\Component\HttpFoundation\Response;

class UserOtpController extends Controller
{
    /**
     * @throws \Exception
     */

    public function __construct()
    {
        $setting_options = com_option_get('otp_login_enabled_disable');

        if (empty($setting_options) || $setting_options === 'off') {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.setting_disabled', ['name' => 'Otp login']));
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
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $customer = Customer::where('phone', $request->phone)->first();

        if (!$customer) {
            return response()->json([
                'message' => __('messages.data_not_found'),
            ]);
        }

        $otp = UserOtp::where('user_id', $customer->id)
            ->where('user_type', 'customer')
            ->where('otp_code', $request->otp)
            ->first();

        $otp_expired = $otp->expired_at < Carbon::now();

        if ($otp_expired) {
            return response()->json([
                'message' => __('messages.expired', ['name' => 'Otp']),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($otp) {
            $otp->delete();
            return response()->json([
                'message' => __('massages.verification_success', ['name' => 'Otp']),
            ]);
        }

        return response()->json([
            'message' => __('massages.verification_failed', ['name' => 'Otp']),
        ]);

    }
}
