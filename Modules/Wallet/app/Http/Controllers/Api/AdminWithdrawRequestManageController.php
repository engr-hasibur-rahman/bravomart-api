<?php

namespace Modules\Wallet\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Mail\DynamicEmail;
use App\Models\EmailTemplate;
use App\Models\Store;
use App\Models\User;
use App\Models\WithdrawalRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
            'id' => 'required|integer|exists:wallet_withdrawals_transactions,id',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Ensure the folder exists, if not, create it
        $withdrawFolder = 'uploads/withdraw';
        if (!Storage::disk('public')->exists($withdrawFolder)) {
            Storage::disk('public')->makeDirectory($withdrawFolder, 0755, true);
        }

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filePath = $file->store($withdrawFolder, 'public');
        }

        // Fetch the pending withdrawal transactions
        $withdraw = WalletWithdrawalsTransaction::where('id', $request->id)
            ->where('status', 'pending')
            ->first();

        if (!$withdraw) {
            return response()->json([
                'status' => false,
                'message' => 'No valid pending withdrawal requests found.',
            ], 404);
        }

        // Process each withdrawal request
        $wallet = Wallet::with('owner')->where([
            'id' => $withdraw->wallet_id,
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
            'attachment' => $filePath,
        ]);

                // mail send to store
                try {
                    $email_template_store_withdrawal_approved = EmailTemplate::where('type', 'withdrawal-approved-for-deliveryman')
                        ->where('status', 1)
                        ->first();

                    // if store and deliveryman
                    if ($withdraw->owner_type === 'App\Models\Store'){
                        $seller_info = User::where('id', $wallet->owner?->store_seller_id)->first();
                        // store info
                        $store_email = $wallet->owner?->email;
                        $store_owner_name = $seller_info->full_name ?? '';
                        $store_name = $wallet->owner?->name;
                        $store_subject = $email_template_store_withdrawal_approved->subject;
                        $store_message = $email_template_store_withdrawal_approved->body;
                        $withdraw_amount = amount_with_symbol_format($withdraw->amount);

                        $store_message = str_replace(["@seller_name", "@store_name", "@amount"],
                            [
                                $store_owner_name,
                                $store_name,
                                $withdraw_amount,
                            ], $store_message);

                        // customer
                        Mail::to($store_email)->send(new DynamicEmail($store_subject, (string)$store_message));

                    }else {
                        $deliveryman_info = User::where('id', $wallet->owner?->id)->first();
                        // store info
                        $email = $deliveryman_info->email;
                        $name = $deliveryman_info->full_name ?? '';

                        $store_subject = $email_template_store_withdrawal_approved->subject;
                        $store_message = $email_template_store_withdrawal_approved->body;
                        $withdraw_amount = amount_with_symbol_format($withdraw->amount);

                        $store_message = str_replace(["@deliveryman_name", "@email", "@amount"],
                            [
                                $name,
                                $email,
                                $withdraw_amount,
                            ], $store_message);

                        // customer
                        Mail::to($email)->send(new DynamicEmail($store_subject, (string)$store_message));
                    }
                } catch (\Exception $th) {
                }

        return response()->json([
            'status' => true,
            'message' => 'Withdrawals approved successfully.',
        ]);
    }


    public function withdrawRequestReject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:wallet_withdrawals_transactions,id',
            'reject_reason' => 'required|string:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // update wallet withdrawals
        $updated = WalletWithdrawalsTransaction::where('id', $request->id)
            ->where('status', 'pending')->first();

        // If no records were updated
        if (!$updated) {
            return response()->json([
                'status' => false,
                'message' => __('messages.reject.failed', ['name' => 'Withdrawal']),
            ], 404);
        }

        $updated->update([
                'status' => 'rejected',
                'reject_reason' => $request->reject_reason,
            ]);


        // mail send to store
        try {
            $email_template_store_withdrawal_approved = EmailTemplate::where('type', 'store-withdrawal-declined')
                ->where('status', 1)
                ->first();

            $store_info = Store::where('id', $updated->owner_id)->first();
            $seller_info = User::where('id', $store_info->store_seller_id)->first();
            // store info
            $store_email = $store_info->email;
            $store_owner_name = $seller_info->full_name ?? '';
            $store_name = $store_info->name;
            $store_subject = $email_template_store_withdrawal_approved->subject;
            $store_message = $email_template_store_withdrawal_approved->body;
            $withdraw_amount = amount_with_symbol_format($updated->amount);

            $store_message = str_replace(["@seller_name", "@store_name", "@amount"],
                [
                    $store_owner_name,
                    $store_name,
                    $withdraw_amount,
                ], $store_message);

            // customer
            Mail::to($store_email)->send(new DynamicEmail($store_subject, (string)$store_message));

        } catch (\Exception $th) {
        }

        return response()->json([
            'status' => true,
            'message' => __('messages.reject.success', ['name' => 'Withdrawal']),
        ]);
    }

}
