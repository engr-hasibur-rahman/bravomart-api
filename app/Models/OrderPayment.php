<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = [
      'order_id',
      'store_id',
      'activity_from',
      'activity_title',
      'activity_value',
    ];
}
