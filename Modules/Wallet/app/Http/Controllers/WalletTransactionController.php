<?php

namespace Modules\Wallet\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Wallet\app\Models\WalletTransaction;
use Modules\Wallet\app\Transformers\WalletTransactionListResource;

class WalletTransactionController extends Controller
{
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

    public function transactionStatus($id)
    {
        // Get the status of a specific transaction
        $transaction = WalletTransaction::findOrFail($id);
        $transaction->status = $transaction->status == 1 ? 0 : 1;
        $transaction->save();
        return response()->json(['message' => 'Transaction status changed successfully']);
    }
}
