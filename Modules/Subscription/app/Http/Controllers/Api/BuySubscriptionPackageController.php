<?php

namespace Modules\Subscription\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Subscription\app\Services\SubscriptionService;

class BuySubscriptionPackageController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function buySubscriptionPackage(Request $request)
    {
        $result = $this->subscriptionService->buySubscriptionPackage($request);
        return response()->json($result);
    }

    public function packagePaymentStatusUpdate(Request $request)
    {
        if(!Auth::guard('sanctum')->user()){
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'],401
            );
        }
        // seller info
        $seller = Auth::guard('sanctum')->user();
        $seller_email = $seller->email ?? '';
        $get_x_hmac = $request->header('X-HMAC');
        $secret_key = 'gdfgdfgdfgdfgdfgdfgdfsgdfgdfgdfgdfgdfgdg';

        // verify the x-HMAC Address and generate key
        $calculate_hmac = hash_hmac('sha256', $get_x_hmac, $secret_key);

        // check the key
        if(!hash_equals($get_x_hmac, $calculate_hmac)){
            return response()->json([
               'success' => false,
               'error' => 'Unauthorized'
            ]);
        }

        return response()->json([
            'success' => true,
            'error' => ''
        ]);
    }

}
