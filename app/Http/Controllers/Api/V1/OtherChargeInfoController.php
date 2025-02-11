<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OtheChargeInfoResource;
use App\Models\SystemCommission;
use Illuminate\Http\Request;

class OtherChargeInfoController extends Controller
{
    public function otherChargeInformation(Request $request){
        $data = SystemCommission::first();
        if (is_null($data) || $data->order_additional_charge_enable_disable === false) {
            return response()->json([
                'success' => false,
                'tax_info' => 'no additional charge'
            ]);
        }

        return response()->json([
            'success' => true,
            'tax_info' => new OtheChargeInfoResource($data)
        ]);
    }
}
