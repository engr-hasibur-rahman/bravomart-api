<?php

namespace Modules\Wallet\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Models\WithdrawalRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Wallet\app\Models\Wallet;
use Modules\Wallet\app\Models\WalletWithdrawalsTransaction;
use Modules\Wallet\app\Transformers\AdminWithdrawListResource;
use Modules\Wallet\app\Transformers\AdminWithdrawRequestResource;

class AdminWithdrawRequestManageController extends Controller
{
    public function withdrawRequestList(Request $request)
    {
        $query = WalletWithdrawalsTransaction::with('owner')->where('status', 'pending');
        // Apply filters if provided
        if (!empty($request->owner_id)) {
            $query->where('owner_id', $request->owner_id);
        }
        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        $withdraws = $query->paginate(10);

        if ($withdraws->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'messages.data_found',
                'data' => AdminWithdrawListResource::collection($withdraws),
                'meta' => new PaginationResource($withdraws)
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => 'messages.data_not_found',
            ]);
        }
    }

    public function withdrawRequestApprove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:wallet_withdrawals_transactions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Fetch the pending withdrawal transactions
        $withdrawals = WalletWithdrawalsTransaction::whereIn('id', $request->ids)
            ->where('status', 'pending')
            ->get();

        if ($withdrawals->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No valid pending withdrawal requests found.',
            ], 404);
        }

        // Process each withdrawal request
        foreach ($withdrawals as $withdraw) {
            $wallet = Wallet::where([
                'owner_id' => $withdraw->owner_id,
                'owner_type' => $withdraw->owner_type,
            ])->first();

            if (!$wallet) {
                return response()->json([
                    'status' => false,
                    'message' => 'Wallet not found for owner ID: ' . $withdraw->owner_id,
                ], 404);
            }

            if ($wallet->balance < $withdraw->amount) {
                return response()->json([
                    'status' => false,
                    'message' => 'Insufficient balance in wallet for withdrawal ID: ' . $withdraw->id,
                ], 400);
            }

            // Deduct the withdrawal amount from the wallet balance
            $wallet->balance -= $withdraw->amount;
            $wallet->withdrawn += $withdraw->amount;
            $wallet->save();

            // Approve the withdrawal
            $withdraw->update([
                'status' => 'approved',
                'approved_by' => auth('api')->id(),
                'approved_at' => now(),
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Withdrawals approved successfully.',
        ]);
    }


    public function withdrawRequestReject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:wallet_withdrawals_transactions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $ids = collect($request->ids);
        $chunkSize = 10000;
        $totalUpdated = 0;

        // Process in chunks
        $ids->chunk($chunkSize)->each(function ($chunk) use (&$totalUpdated) {
            $updated = WalletWithdrawalsTransaction::whereIn('id', $chunk)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);

            $totalUpdated += $updated;
        });

        // If no records were updated
        if ($totalUpdated === 0) {
            return response()->json([
                'status' => false,
                'message' => __('messages.reject.failed', ['name' => 'Withdrawal']),
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => __('messages.reject.success', ['name' => 'Withdrawal']),
            'total_rejected' => $totalUpdated,
        ]);
    }

}
