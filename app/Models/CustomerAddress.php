<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = [
        'customer_id',
        'title',
        'type',
        'email',
        'contact_number',
        'address',
        'latitude',
        'longitude',
        'area_id',
        'road',
        'house',
        'floor',
        'postal_code',
        'is_default',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function area()
    {
        return $this->belongsTo(StoreArea::class, 'area_id');
    }
}
