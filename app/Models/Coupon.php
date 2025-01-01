<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'title',
        'code',
        'discount_type',
        'discount',
        'min_order_value',
        'max_discount',
        'store_id',
        'usage_limit',
        'per_user_limit',
        'usage_count',
        'start_date',
        'end_date',
        'description',
        'status',
        'created_by',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public $translationKeys = [
        'title',
        'description'
    ];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'coupon_users');
    }

    public function store()
    {
        return $this->belongsTo(ComMerchantStore::class, 'store_id');
    }

    // Check if the coupon can be applied by a user
    public function canBeUsedByCustomer(Customer $customer)
    {
        $usedCount = $this->customers()->where('user_id', $customer->id)->count();
        return ($this->usage_count < $this->usage_limit &&
            $usedCount < $this->per_user_limit &&
            $this->start_date <= now() &&
            $this->end_date >= now());
    }
}
