<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawGateway extends Model
{
    protected $fillable = [
        'name',       // Method name (e.g., "PayPal", "Bank Transfer")
        'fields',     // JSON fields (e.g., API keys, account details)
        'status',     // Status (1 = active, 0 = inactive)
    ];

    public function records()
    {
        return $this->hasMany(WithdrawalRecord::class, 'withdraw_gateway_id');
    }
}
