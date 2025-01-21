<?php

namespace Modules\Wallet\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'message' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // auth user check
        if (auth()->guard('api_customer')->check()) {
            $user = auth()->guard('api_customer')->user();
        } elseif (auth()->guard('api')->check()) {
            $user = auth()->guard('api')->user();
        }

        // If no user is authenticated
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // find user wallet
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
         $wallet_history = WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'amount' => $validated['amount'],
                'type' => 'credit',
                'purpose' => 'deposit',
                'status' => 0,
            ]);

            $wallet_history_id = $wallet_history->id;

            return response()->json([
                'message' => 'Deposit created successfully',
                'wallet_history_id' => $wallet_history_id,
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
        // auth user check
        if (auth()->guard('api_customer')->check()) {
            $user = auth()->guard('api_customer')->user();
        } elseif (auth()->guard('api')->check()) {
            $user = auth()->guard('api')->user();
        }

        // If no user is authenticated
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
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

    public function paymentStatusUpdate(Request $request)
    {

        // Check if the user is authenticated
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized'
            ], 401);
        }


        // Validate the required inputs using Validator::make
        $validated = Validator::make($request->all(), [
            'wallet_history_id' => 'required|integer',
            'transaction_ref' => 'nullable|string|max:255',
            'transaction_details' => 'nullable|string|max:1000',
        ]);

        // Check if validation fails
        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validated->errors(),
            ], 400);
        }

        // Get necessary details
        $customerEmail = $user->email ?? '';
        $providedHmac = $request->header('X-HMAC');
        $secretKey = '4b3403665fea6e60060fca1953b6e1eaa5c4dc102174f7e923217b87df40523a';

        // Generate the HMAC for comparison
        $calculatedHmac = hash_hmac('sha256', $customerEmail, $secretKey);

        // Verify HMAC
        if (!hash_equals($providedHmac, $calculatedHmac)) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized Key Not Match'
            ], 403);
        }

        // Find the wallet history
        $wallet = WalletTransaction::where('id', $request->wallet_history_id)->first();

        // Check if the wallet history exists
        if (empty($wallet)) {
            return response()->json([
                'success' => false,
                'message' => 'Wallet not found'
            ], 404);
        }

        // Update the wallet history
        $wallet->update([
            'payment_status' => 'paid',
            'transaction_ref' => $request->transaction_ref ?? null,
            'transaction_details' => $request->transaction_details ?? null,
            'status' => 1,
        ]);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Payment status updated successfully',
        ]);
    }

}
