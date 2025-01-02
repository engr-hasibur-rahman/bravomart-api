<?php

namespace Modules\Wallet\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Wallet\app\Models\WalletTransaction;

class WalletTransactionController extends Controller
{
    public function records()
    {
        // Get all transaction records for the wallet
        $transactions = WalletTransaction::all(); // Modify as needed
        return response()->json($transactions);
    }

    public function transactionStatus($id)
    {
        // Get the status of a specific transaction
        $transaction = WalletTransaction::findOrFail($id);
        return response()->json(['status' => $transaction->status]);
    }
}
