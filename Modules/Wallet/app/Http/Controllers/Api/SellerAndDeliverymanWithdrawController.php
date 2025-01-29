<?php

namespace Modules\Wallet\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Models\WithdrawalRecord;
use App\Models\WithdrawGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Wallet\app\Transformers\WithdrawDetailsResource;
use Modules\Wallet\app\Transformers\WithdrawListResource;

class SellerAndDeliverymanWithdrawController extends Controller
{
    public function withdrawAllList(Request $request)
    {
        if (auth('api')->user()->activity_scope !== 'system_level') {
            return unauthorized_response();
        }

        $query = WithdrawalRecord::with(['withdrawGateway'])
            ->where('user_id', auth('api')->user()->id);

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
                'status_code' => 200,
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
        $withdraw = WithdrawalRecord::with('withdrawGateway')->find($request->id);
        if (!empty($withdraw)) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => new WithdrawDetailsResource($withdraw)
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
        $gateway_fields = json_decode($gateway_options->fields);
        $success = WithdrawalRecord::create([
            'user_id' => auth('api')->id(),
            'withdraw_gateway_id' => $request->withdraw_gateway_id,
            'amount' => $request->amount,
            'details' => $request->details ?? null,
            'fee' => 0.00,
            'gateways_options' => json_encode($gateway_fields),
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
