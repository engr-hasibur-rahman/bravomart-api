<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = [
      'order_id',
      'payment_method',
      'payment_status',
      'transaction_ref',
      'transaction_details',
      'paid_amount',
    ];
}
