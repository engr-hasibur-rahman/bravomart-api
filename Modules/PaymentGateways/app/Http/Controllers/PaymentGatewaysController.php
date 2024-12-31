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
    public function settingsGetAndUpdate(Request $request, $gateway)
    {
        if ($request->isMethod('POST')) {
            // Perform validation directly on the request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|exists:payment_gateways,name',
                'description' => 'nullable|string',
                'auth_credentials' => 'required|array',
                'status' => 'required|boolean',
                'is_test_mode' => 'required|boolean',
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
            $gateway = PaymentGateway::where('name', $validatedData['name'])->first();


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
                'is_test_mode' => $request->get('is_test_mode', $gateway->is_test_mode),
                'auth_credentials' => json_encode($auth_credentials),
            ]);

            Artisan::call('optimize:clear');

            return response()->json([
                'status' => 'success',
                'message' => 'Payment gateway updated successfully.'
            ]);
        }

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

}
