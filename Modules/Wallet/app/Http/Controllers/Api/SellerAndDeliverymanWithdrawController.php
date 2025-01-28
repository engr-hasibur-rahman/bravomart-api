<?php

namespace Modules\Wallet\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRecord;
use App\Models\WithdrawGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerAndDeliverymanWithdrawController extends Controller
{
    public function withdrawList()
    {
        $withdraws = WithdrawalRecord::with('withdrawGateway')
            ->where('user_id', auth('api')->id)
            ->latest()
            ->paginate(10);
        if (!empty($withdrawRequests)) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => $withdraws
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => __('messages.data_not_found'),
            ]);
        }
    }

    public function withdrawDetails(Request $request)
    {
        $withdraw = WithdrawalRecord::with('withdrawGateway')->find($request->id);
        if (!empty($withdraw)) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => $withdraw
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => __('messages.data_not_found'),
            ]);
        }
    }

    public function withdrawRequest(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "withdraw_gateway_id" => "required|integer|exists:withdraw_gateways,id",
            "amount" => "required",
            "details" => "nullable|string|max:255",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $gateway_options = WithdrawGateway::where('id', $request->withdraw_gateway_id)->first();
        $success = WithdrawalRecord::create([
            'user_id' => auth('api')->id(),
            'withdraw_gateway_id' => $request->withdraw_gateway_id,
            'amount' => $request->amount,
            'details' => $request->details ?? null,
            'fee' => 0.00,
            'gateways_options' => json_encode($gateway_options),
        ]);
        if ($success) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.request_success'),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => __('messages.request_failed'),
            ]);
        }
    }
}
