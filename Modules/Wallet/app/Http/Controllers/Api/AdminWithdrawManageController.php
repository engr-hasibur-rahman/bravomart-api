<?php

namespace Modules\Wallet\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRecord;
use Illuminate\Http\Request;

class AdminWithdrawManageController extends Controller
{
    public function withdrawAllList()
    {
        if(auth('api')->user()->activity_scope !== 'system_level'){
            unauthorized_response();
        }
        $withdraws = WithdrawalRecord::with(['user', 'withdrawGateway'])
            ->latest()->paginate(10);
        if (!empty($withdraws)) {
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
        if(auth('api')->user()->activity_scope !== 'system_level'){
            unauthorized_response();
        }
        $withdraw = WithdrawalRecord::with(['user', 'withdrawGateway'])->find($request->id);
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
}
