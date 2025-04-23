<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Models\WithdrawalRecord;
use Illuminate\Http\Request;
use Modules\Wallet\app\Models\WalletWithdrawalsTransaction;
use Modules\Wallet\app\Transformers\AdminWithdrawListResource;
use Modules\Wallet\app\Transformers\WalletWithdrawActivityResource;

class AdminWithdrawManageController extends Controller
{
    public function withdrawAllList(Request $request)
    {
        $query = WalletWithdrawalsTransaction::with('owner');
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

    public function withdrawDetails(Request $request)
    {
        $WithdrawalRecord = WalletWithdrawalsTransaction::with('owner', 'wallet')->find($request->id);
        if ($WithdrawalRecord) {
            return response([
                'status' => true,
                'data' => new AdminWithdrawListResource($WithdrawalRecord),
                'activity' => new WalletWithdrawActivityResource($WithdrawalRecord),
            ]);
        } else {
            return response([
                'status' => false,
                'message' => __('messages.data_not_found'),
                'data' => null
            ]);
        }
    }
}
