<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalRecord extends Model
{
    protected $fillable = [
        "user_id",
        "withdraw_gateway_id",
        "amount",
        "fee",
        "gateways_options",
        "status",
        "details",
        "approved_by",
        "approved_at",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function withdrawGateway()
    {
        return $this->belongsTo(WithdrawGateway::class, 'withdraw_gateway_id');
    }
}
