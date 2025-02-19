<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
        'user_id', 'user_type', 'current_balance', 'earnings', 'withdrawn', 'refunds',
    ];

    public function user()
    {
        if ($this->user_type === 'store') {
            return $this->belongsTo(Store::class, 'user_id');
        } elseif ($this->user_type === 'deliveryman') {
            return $this->belongsTo(DeliveryMan::class, 'user_id');        }

        return null;
    }
    public function scopeForStore($query, $storeId)
    {
        return $query->where('user_type', 'store')->where('user_id', $storeId);
    }
    public function scopeForDeliveryMan($query, $deliveryManId)
    {
        return $query->where('user_type', 'deliveryman')->where('user_id', $deliveryManId);
    }
}
