<?php

namespace Modules\Wallet\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WithdrawGateway;
use Dotenv\Validator;
use Illuminate\Http\Request;

class AdminWithdrawGatewayManageController extends Controller
{
    public function withdrawGatewayAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'fields' => 'nullable|json',
            'status' => 'required|integer|in:0,1',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $success = WithdrawGateway::create($request->all());
        if ($success) {
            return response()->json([
                'status' => true,
                'status_code' => 201,
                'message' => __('messages.save_success', ['name' => 'Gateway']),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => __('messages.save_failed', ['name' => 'Gateway']),
            ]);
        }
    }
}
