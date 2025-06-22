<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawGateway extends Model
{
    protected $fillable = [
        'name',
        'fields',
        'status',
    ];

    public function records()
    {
        return $this->hasMany(WithdrawalRecord::class, 'withdraw_gateway_id');
    }
}
