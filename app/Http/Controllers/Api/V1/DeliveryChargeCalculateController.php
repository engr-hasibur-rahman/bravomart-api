<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\DeliveryChargeHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryChargeCalculateController extends Controller
{
    public function calculateDeliveryCharge(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'area_id' => 'required|integer',
            'customer_latitude' => 'required|numeric',
            'customer_longitude' => 'required|numeric',
        ]);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $areaId = $request->input('area_id'); // Correct for POST method
        $customerLat = $request->input('customer_latitude');
        $customerLng = $request->input('customer_longitude');

        $result = DeliveryChargeHelper::calculateDeliveryCharge($areaId, $customerLat, $customerLng);

        return response()->json($result);
    }
}
