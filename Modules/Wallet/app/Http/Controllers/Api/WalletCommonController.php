<?php

namespace Modules\Wallet\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Wallet\app\Models\Wallet;
use Modules\Wallet\app\Models\WalletTransaction;
use Modules\Wallet\app\Transformers\UserWalletDetailsResource;
use Modules\Wallet\app\Transformers\WalletTransactionListResource;

class WalletCommonController extends Controller
{
    public function myWallet()
    {
         // check which guard is being used
        if (auth()->guard('api_customer')->check()) {
            $user = auth()->guard('api_customer')->user();
        } elseif (auth()->guard('api')->check()) {
            $user = auth()->guard('api')->user();
        }

        // If no user is authenticated
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        //  wallets for the authenticated user
        $wallets = Wallet::forOwner($user)->first();

        if (!$wallets) {
            return response()->json([
               'success' => false,
               'message' => 'User Wallet not found'
            ],404);
        }

        return response()->json([
            'wallets' => new UserWalletDetailsResource($wallets),
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
        $user = auth()->guard('api')->user();
        $wallets = Wallet::forOwner($user)->paginate(10);
        // Find the wallet where the deposit will be made
        $wallet = Wallet::where('id', $validated['wallet_id'])
            ->where('owner_id', $user->id)
            ->first();

        // Check if validation failed
        if (empty($wallet)) {
            return response()->json([
                'message' => 'wallet not found',
            ], 404);
        }

        try {

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
                'message' => 'Deposit created successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create deposit',
                'error' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }


    public function transactionRecords()
    {
        //check auth
        $user = auth()->guard('api')->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // user's wallet
        $wallet = Wallet::forOwner($user)->first();
        if (!$wallet) {
            return response()->json(['message' => 'Wallet not found'], 404);
        }

        // wallet transactions with pagination
        $transactions = WalletTransaction::where('wallet_id', $wallet->id)
            ->paginate(10);

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
