<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawGateway;
use Illuminate\Http\Request;

class AdminWithdrawSettingsController extends Controller
{
    /**
     * Display a listing of the withdraw gateways.
     */
    public function index()
    {
        $methods = WithdrawGateway::all();
        return response()->json([
            'status' => 'success',
            'data' => $methods,
        ]);
    }

    /**
     * Store a newly created withdraw gateway.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'fields' => 'nullable|json',
            'status' => 'nullable|integer|in:0,1',
        ]);

        $method = WithdrawGateway::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Withdraw gateway created successfully.',
            'data' => $method,
        ], 201);
    }

    /**
     * Display the specified withdraw gateway.
     */
    public function show($id)
    {
        $method = WithdrawGateway::find($id);

        if (!$method) {
            return response()->json([
                'status' => 'error',
                'message' => 'Withdraw gateway not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $method,
        ]);
    }

    /**
     * Update the specified withdraw gateway.
     */
    public function update(Request $request, $id)
    {
        $method = WithdrawGateway::find($id);

        if (!$method) {
            return response()->json([
                'status' => 'error',
                'message' => 'Withdraw gateway not found.',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'fields' => 'nullable|json',
            'status' => 'nullable|integer|in:0,1',
        ]);

        $method->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Withdraw gateway updated successfully.',
            'data' => $method,
        ]);
    }

    /**
     * Toggle the status of the specified withdraw gateway.
     */
    public function statusChange($id)
    {
        $method = WithdrawGateway::find($id);

        if (!$method) {
            return response()->json([
                'status' => 'error',
                'message' => 'Withdraw gateway not found.',
            ], 404);
        }

        $method->status = !$method->status;
        $method->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Withdraw gateway status updated successfully.',
            'data' => ['status' => $method->status],
        ]);
    }

    /**
     * Remove the specified withdraw gateway.
     */
    public function destroy($id)
    {
        $method = WithdrawGateway::find($id);

        if (!$method) {
            return response()->json([
                'status' => 'error',
                'message' => 'Withdraw gateway not found.',
            ], 404);
        }

        $method->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Withdraw gateway deleted successfully.',
        ]);
    }
}
