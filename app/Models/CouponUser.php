<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    protected $fillable = [
        'coupon_id',
        'user_id',
        'used_count',
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
}
