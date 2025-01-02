<?php

namespace Modules\Wallet\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'walletable_id', // Foreign key for polymorphic relation
        'walletable_type', // The type of the related model (User, Customer)
        'balance',
        'status',
    ];

    /**
     * Define the polymorphic relationship to User or Customer.
     */
    public function walletable()
    {
        return $this->morphTo();
    }

    /**
     * Define the relationship to WalletTransaction.
     */
    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }


}
