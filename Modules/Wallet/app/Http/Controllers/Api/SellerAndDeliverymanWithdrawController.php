<?php

namespace Modules\Wallet\app\Http\Controllers\Api;

use App\Enums\WalletOwnerType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Models\WithdrawGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Wallet\app\Models\Wallet;
use Modules\Wallet\app\Models\WalletWithdrawalsTransaction;
use Modules\Wallet\app\Transformers\WithdrawDetailsResource;
use Modules\Wallet\app\Transformers\WithdrawListResource;

class SellerAndDeliverymanWithdrawController extends Controller
{
    public function withdrawAllList(Request $request)
    {
        if (!auth('api')->user()->activity_scope === 'store_level' || !auth('api')->user()->activity_scope === 'delivery_level') {
            return unauthorized_response();
        }

        $query = WalletWithdrawalsTransaction::where('owner_id', $request->store_id);

        if (isset($request->amount)) {
            $query->where('amount', $request->amount);
        }

        if (isset($request->status)) {
            $query->where('status', $request->status);
        }

        if (isset($request->start_date) && isset($request->end_date)) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $withdraws = $query->latest()->paginate(10);

        if ($withdraws->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'message' => __('messages.data_found'),
                'data' => WithdrawListResource::collection($withdraws),
                'meta' => new PaginationResource($withdraws)
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
        $withdraw = WalletWithdrawalsTransaction::find($request->id);
        if (!empty($withdraw)) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => 'messages.data_found',
                'data' => new WithdrawDetailsResource($withdraw)
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => 'messages.data_not_found',
            ]);
        }
    }

    public function withdrawRequest(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            "store_id" => "required|exists:stores,id", // store exists
            "withdraw_gateway_id" => "required|integer|exists:withdraw_gateways,id",
            "gateway_name" => "required|string|max:50",
            "amount" => "required",
            "details" => "nullable|string|max:255",
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $owner_id = $request->store_id;
        $withdraw_amount = $request->amount;

        $min_limit = com_option_get('minimum_withdrawal_limit');
        $max_limit = com_option_get('maximum_withdrawal_limit');
        if ($min_limit !== null || $max_limit !== null) {
            if ($withdraw_amount < intval($min_limit) || $withdraw_amount > intval($max_limit)) {
                return response()->json([
                    'message' => "Please enter a valid amount between " .
                        $min_limit . ' - ' .
                        $max_limit
                ], 422);
            }
        }

        // balance check
        $ownerType = WalletOwnerType::STORE->value;

        $wallet = Wallet::where('owner_id', $owner_id)
            ->where('owner_type', $ownerType)
            ->first();

        if (empty($wallet)){
            return response()->json([
               'message' => 'You have no balance.',
            ],404);
        }

        if (!empty($wallet) && $wallet->balance <= 0){
            return response()->json([
               'message' => 'You have insufficient balance.',
            ]);
        }

        // Validate if store finances exist and current balance is sufficient
        if ($wallet->balance < $request->amount){
            return response()->json([
               'message' => 'You have insufficient balance.',
            ]);
        }

        $success = WalletWithdrawalsTransaction::create([
            'owner_id' => $owner_id,
            'owner_type' => WalletOwnerType::STORE->value,
            'withdraw_gateway_id' => $request->withdraw_gateway_id,
            'gateway_name' => $request->gateway_name,
            'amount' => $request->amount,
            'details' => $request->details ?? null,
            'fee' => 0.00,
            'gateways_options' => json_encode($request->gateways),
        ]);

        if ($success) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.request_success', ['name' => 'Withdrawal']),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => __('messages.request_failed', ['name' => 'Withdrawal']),
            ]);
        }
    }
}
