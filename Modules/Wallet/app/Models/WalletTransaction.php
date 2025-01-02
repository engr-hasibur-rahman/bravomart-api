<?php

namespace Modules\Wallet\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'transaction_ref',
        'transaction_details',
        'amount',
        'type',
        'purpose',
        'status',
    ];

    /**
     * Define the relationship to the Wallet.
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

}
