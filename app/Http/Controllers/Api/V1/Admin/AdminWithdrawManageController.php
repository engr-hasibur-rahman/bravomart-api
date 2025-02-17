<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRecord;
use Illuminate\Http\Request;

class AdminWithdrawManageController extends Controller
{
    public function withdrawAllList(Request $request)
    {
        $query = WithdrawalRecord::query();

        // Apply filters if provided
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('from_date') && $request->has('to_date')) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        $all_withdraw = $query->paginate(10);
        return response([
            'status' => true,
            'data' => $all_withdraw->count() > 0 ? $all_withdraw : null
        ]);
    }

    public function withdrawDetails(Request $request)
    {
        $WithdrawalRecord = WithdrawalRecord::find($request->id);
        // if the record exists
        if ($WithdrawalRecord) {
            return response([
                'status' => true,
                'message' => 'Record Found',
                'data' => $WithdrawalRecord
            ]);
        } else {
            return response([
                'status' => false,
                'message' => 'Not Found',
                'data' => null
            ]);
        }
    }
}
