<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminCommissionManageController extends Controller
{
    public function commissionSettings(Request $request)
    {
        if ($request->isMethod('POST')) {
            // Validate input
            $validatedData = $request->validate([
                'subscription_enabled' => 'required|boolean',
                'commission_enabled' => 'required|boolean',
                'commission_charge_type' => 'nullable',
                'commission_amount' => 'nullable|numeric|min:0',
                'default_order_commission_rate' => 'nullable|numeric|min:0',
                'default_delivery_commission_charge' => 'nullable|numeric|min:0',
                'order_shipping_charge' => 'nullable|numeric|min:0',
                'order_confirmation_by' => 'nullable|string|max:255',
                'order_include_tax_amount' => 'nullable|boolean',
                'order_additional_charge_enable_disable' => 'nullable|boolean',
                'order_additional_charge_name' => 'nullable',
                'order_additional_charge_amount' => 'nullable|numeric|min:0',
            ]);

            // Update or create settings
            $systemCommission = SystemCommission::first();
            if (!$systemCommission) {
                $systemCommission = new SystemCommission();
            }

            $systemCommission->fill($validatedData);
            $systemCommission->save();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Commission settings Updated Successfully',
            ]);
        }

        // Handle GET request: Retrieve existing settings
        $response = SystemCommission::first();
        if (!$response) {
            return response()->json([
                'success' => false,
                'message' => 'Commission settings not found',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $response,
        ]);
    }

    public function commissionHistory(Request $request)
    {

        return $this->success('test');
    }

}
