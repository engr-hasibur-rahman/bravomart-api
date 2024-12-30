<?php

namespace Modules\PaymentGateways\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\PaymentGateways\app\Models\PaymentGateway;

class PaymentGatewaysController extends Controller
{
    public function getSettings($gateway)
    {
        $paymentGateway = PaymentGateway::where('name', $gateway)->first();

        if (!$paymentGateway) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment gateway not found.'
            ], 404);
        }
        $paymentGateway->auth_credentials = json_decode($paymentGateway->auth_credentials);

        return response()->json([
            'status' => 'success',
            'gateways' => $paymentGateway
        ]);
    }

    public function updateGateway(Request $request)
    {
        // Perform validation directly on the request
        $validator = Validator::make($request->all(), [
            'gateway_name' => 'required|string|exists:payment_gateways,name',
            'description' => 'nullable|string',
            'auth_credentials' => 'required|array',
            'status' => 'required|boolean',
            'test_mode' => 'required|boolean',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Get validated data
        $validatedData = $validator->validated();

        // Proceed with business logic using $validatedData
        $gateway = PaymentGateway::where('name', $validatedData['gateway_name'])->first();



        if (!$gateway) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid gateway name.'
            ], 400);
        }

        $auth_credentials = $request->get('auth_credentials', []);
        $gateway->update([
            'image' => $request->get('image', $gateway->image),
            'description' => $request->get('description', $gateway->description),
            'status' => $request->get('status', $gateway->status),
            'test_mode' => $request->get('test_mode', $gateway->test_mode),
            'auth_credentials' => json_encode($auth_credentials),
        ]);

        Artisan::call('optimize:clear');

        return response()->json([
            'status' => 'success',
            'message' => 'Payment gateway updated successfully.'
        ]);
    }
}
