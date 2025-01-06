<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawGateway;
use Illuminate\Http\Request;

class AdminWithdrawSettingsController extends Controller
{
    public function index()
    {
        $methods = WithdrawGateway::all();
        return response()->json($methods);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'fields' => 'nullable|json',
            'min_withdrawal' => 'nullable|numeric',
            'max_withdrawal' => 'nullable|numeric',
            'transaction_fee' => 'nullable|numeric',
            'fee_type' => 'nullable|string|in:fixed,percentage',
        ]);

        $method = WithdrawGateway::create($validated);
        return response()->json($method, 201);
    }

    public function show($id)
    {
        $method = WithdrawGateway::findOrFail($id);
        return response()->json($method);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'fields' => 'nullable|json',
            'min_withdrawal' => 'nullable|numeric',
            'max_withdrawal' => 'nullable|numeric',
            'transaction_fee' => 'nullable|numeric',
            'fee_type' => 'nullable|string|in:fixed,percentage',
            'status' => 'nullable|integer|in:0,1',
        ]);

        $method = WithdrawGateway::findOrFail($id);
        $method->update($validated);
        return response()->json($method);
    }

    public function statusChange($id)
    {
        $method = WithdrawGateway::findOrFail($id);
        $method->status = !$method->status;
        $method->save();
        return response()->json(['status' => $method->status]);
    }

    public function destroy($id)
    {
        WithdrawGateway::destroy($id);
        return response()->json(['message' => 'Withdraw Method deleted successfully']);
    }
}
