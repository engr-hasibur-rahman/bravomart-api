<?php

namespace Modules\Wallet\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Wallet\app\Models\Wallet;
use Modules\Wallet\app\Models\WalletTransaction;
use Modules\Wallet\app\Transformers\WalletListResource;
use Modules\Wallet\app\Transformers\WalletTransactionListResource;

class WalletSellerController extends Controller
{

    public function index()
    {
        $wallets = Wallet::where('user_id', auth()->guard('api')->user()->id)->paginate(10);
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


    public function depositCreate(Request $request)
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


    public function records()
    {

        $transactions = WalletTransaction::paginate(10);
        return response()->json([
            'wallets' => WalletTransactionListResource::collection($transactions),
            'pagination' => [
                'total' => $transactions->total(),
                'per_page' => $transactions->perPage(),
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'from' => $transactions->firstItem(),
                'to' => $transactions->lastItem(),
            ],
        ]);
    }

}
