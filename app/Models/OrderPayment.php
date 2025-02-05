<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = [
      'order_id',
      'payment_gateway',
      'payment_status',
      'transaction_ref',
      'transaction_details',
      'paid_amount',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
