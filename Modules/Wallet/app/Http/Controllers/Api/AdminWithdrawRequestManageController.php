<?php

namespace Modules\Wallet\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminWithdrawRequestManageController extends Controller
{
    public function withdrawRequestList()
    {
        if(auth('api')->user()->activity_scope !== 'system_level'){
            unauthorized_response();
        }
        $withdrawRequests = WithdrawalRecord::with(['user', 'withdrawGateway'])
            ->where('status', 'pending')->paginate(10);
        if (!empty($withdrawRequests)) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => $withdrawRequests
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => __('messages.data_not_found'),
            ]);
        }
    }

    public function withdrawRequestApprove(Request $request)
    {
        if(auth('api')->user()->activity_scope !== 'system_level'){
            unauthorized_response();
        }
        $validator = Validator::make(request()->all(), [
            'ids*' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $success = WithdrawalRecord::whereIn('id', $request->ids)
            ->where('status', '!=', 'rejected')
            ->where('status', 'pending')
            ->update([
                'status' => 'approved',
                'approved_by' => auth('api')->id(),
                'approved_at' => Carbon::now()
            ]);
        if ($success) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.approve.success', ['name' => 'Withdrawal']),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => __('messages.approve.failed', ['name' => 'Withdrawal']),
            ]);
        }
    }

    public function withdrawRequestReject(Request $request)
    {
        if(auth('api')->user()->activity_scope !== 'system_level'){
            unauthorized_response();
        }
        $validator = Validator::make(request()->all(), [
            'ids*' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $success = WithdrawalRecord::whereIn('id', $request->ids)
            ->where('status', '!=', 'approved')
            ->update(['status' => 'rejected']);
        if ($success) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.reject.failed', ['name' => 'Withdrawal']),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => __('messages.reject.failed', ['name' => 'Withdrawal']),
            ]);
        }
    }
}
