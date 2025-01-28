<?php

namespace Modules\Wallet\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Wallet\app\Models\Wallet;
use Modules\Wallet\app\Models\WalletTransaction;
use Modules\Wallet\app\Transformers\WalletListResource;
use Modules\Wallet\app\Transformers\WalletTransactionListResource;

class WalletManageAdminController extends Controller
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

    public function index(Request $request)
    {

        $wallets = Wallet::query();

        // Filter by owner_id if provided
        if ($request->has('owner_id') && $request->input('owner_id') !== '') {
            $wallets->where('owner_id', $request->input('owner_id'));
        }

        // Filter by owner_type if provided
        $wallet_type = $request->has('owner_type') ?
            ($request->input('owner_type') === 'customer' ? 'App\Models\Customer' :
                ($request->input('owner_type') === 'user' ? 'App\Models\User' : 'all')) :
            'all';

        // Apply the filter if the owner_type is valid and not 'all'
        if ($wallet_type !== 'all') {
            $wallets->where('owner_type', $wallet_type);
        }

        // Filter by status if provided
        if (!empty($request->input('status')) && $request->input('status') !== '') {
            $wallets->where('status', $request->input('status'));
        }

        // Paginate the results with a default of 10 per page
        $wallets = $wallets->paginate(10);

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
        $wallet->status = $wallet->status == 1 ? 0 : 1;
        $wallet->save();

        return response()->json([
                'message' => 'Deposit status changed successfully']
        );
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
            $errors = $validator->errors()->all();
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $errors,
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


    public function transactionRecords(Request $request)
    {

        // Get the start and end date from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = WalletTransaction::query();

        // transactions by date range
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            // Apply the date filter
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Paginate
        $transactions = $query->paginate(10);

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

    public function transactionStatus($id)
    {
        // specific transaction
        $transaction = WalletTransaction::findOrFail($id);
        $transaction->status = $transaction->status == 1 ? 0 : 1;
        $transaction->save();
        return response()->json(['message' => 'Transaction status changed successfully']);
    }
}
