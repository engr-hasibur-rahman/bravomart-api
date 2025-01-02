<?php

namespace Modules\Wallet\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Wallet\app\Models\Wallet;
use Modules\Wallet\app\Models\WalletTransaction;
use Modules\Wallet\app\Transformers\WalletListResource;

class WalletController extends Controller
{
    public function depositSettings(Request $request)
    {
         if ($request->isMethod('post')) {
             com_option_update('max_deposit_per_transaction', $request->max_deposit_per_transaction);
             return response()->json(['message' => 'Wallet settings successfully']);
         }
        $wallet_settings = com_option_get('max_deposit_per_transaction');
        return response()->json([
            'wallet_settings' => $wallet_settings
        ]);
    }

    public function index()
    {
        $wallets = Wallet::paginate(10);
        return response()->json([
            'wallets' => WalletListResource::collection($wallets),
            'pagination' => [
                'total' => $wallets->total(),
                'per_page' => $wallets->perPage(),
                'current_page' => $wallets->currentPage(),
                'last_page' => $wallets->lastPage(),
                'from' => $wallets->firstItem(),
                'to' => $wallets->lastItem(),
            ],
        ]);
    }

    public function status($id = null)
    {
        $wallet = Wallet::findOrFail($id);
        return response()->json($wallet->status);
    }

    public function depositCreateByAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric|min:0.01',
            'transaction_details' => 'nullable|string',
            'transaction_ref' => 'nullable|string|unique:wallet_transactions,transaction_ref',
            'type' => 'nullable|string',
            'purpose' => 'nullable|string',
        ]);

        // Check if validation failed
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        try {
            // Find the wallet where the deposit will be made
            $wallet = Wallet::findOrFail($validated['wallet_id']);
            // Update the wallet balance
            $wallet->balance += $validated['amount'];
            $wallet->save();

            // Create
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'transaction_ref' => $validated['transaction_ref'] ?? 'TXN' . strtoupper(uniqid()),
                'transaction_details' => $validated['transaction_details'] ?? 'Admin deposit',
                'amount' => $validated['amount'],
                'type' => 'credit',
                'purpose' => 'deposit',
                'status' => 1,
            ]);
            return response()->json([
                'message' => 'Deposit created successfully']
            );

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create deposit',
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }


}
