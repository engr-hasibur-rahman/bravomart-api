<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\DeliveryChargeHelper;
use App\Http\Resources\Admin\OtheChargeInfoResource;
use App\Http\Resources\Order\StoreTaxInfoResource;
use App\Models\Store;
use App\Models\SystemCommission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Wallet\app\Models\Wallet;

class OtherChargeInfoController extends Controller
{
    public function otherChargeInformation(){
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

    public function getCheckoutInfo(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'area_id' => 'required|integer',
            'customer_latitude' => 'required|numeric',
            'customer_longitude' => 'required|numeric',
            'store_ids' => 'required|array',
            'store_ids.*' => 'integer|exists:stores,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Handle delivery charge calculation
        $areaId = $request->input('area_id');
        $customerLat = $request->input('customer_latitude');
        $customerLng = $request->input('customer_longitude');
        $deliveryCharge = DeliveryChargeHelper::calculateDeliveryCharge($areaId, $customerLat, $customerLng);

        // Handle tax info
        $storeIds = array_unique($request->input('store_ids'));
        $taxInfo = Store::whereIn('id', $storeIds)->select('id', 'tax')->get();

        // Handle other charges
        $otherCharges = SystemCommission::first();
        $otherChargeInfo = ($otherCharges && $otherCharges->order_additional_charge_enable_disable)
            ? new OtheChargeInfoResource($otherCharges)
            : 'no additional charge';

        return response()->json([
            'success' => true,
            'delivery_charge' => $deliveryCharge,
            'tax_info' => StoreTaxInfoResource::collection($taxInfo),
            'other_charge_info' => $otherChargeInfo
        ]);
    }

    public function removeUserDemoData(Request $request){

        $user_level = $request->input('user_level');

        if ($user_level == 'delivery_level'){
            $users = User::with(['reviews', 'chats'])
                ->where('activity_scope', $user_level)
                ->get();
        }

//        if ($user_level == 'store_level'){
//            $users = User::with(['wallet', 'chats'])
//                ->where('activity_scope', $user_level)
//                ->get();
//        }
//
//        if ($user_level == 'system_level'){
//            $users = User::with(['wallet', 'reviews', 'chats'])
//                ->where('activity_scope', $user_level)
//                ->get();
//        }




        foreach ($users as $user) {
            // Only delete wallet if this user is owner (owner_type check optional)
            Wallet::where('owner_id', $user->id)->where('owner_type', 'App\Models\User')->forceDelete();

            $user->reviews()->forceDelete();
            $user->chats()->forceDelete();

            // Finally delete the user
            $user->forceDelete();
        }

     }

}
