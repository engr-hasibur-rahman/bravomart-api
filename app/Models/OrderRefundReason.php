<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderRefundReason extends Model
{
    protected $fillable = [
        'reason'
    ];

    public function orderRefunds()
    {
        return $this->hasMany(OrderRefund::class);
    }
}
