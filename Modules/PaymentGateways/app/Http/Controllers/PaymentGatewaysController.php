<?php

namespace Modules\PaymentGateways\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\PaymentGateways\app\Models\PaymentGateway;
use Modules\PaymentGateways\app\Transformers\PaymentGatewaysListPublicResource;


class PaymentGatewaysController extends Controller
{
    public function paymentGateways(){
        $paymentGateways = PaymentGateway::where('status', 1)->get();
        return response()->json([
            'paymentGateways' => PaymentGatewaysListPublicResource::collection($paymentGateways),
        ]);
    }

}
