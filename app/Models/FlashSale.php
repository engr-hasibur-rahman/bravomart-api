<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'thumbnail_image',
        'cover_image',
        'discount_type',
        'discount_price',
        'special_price',
        'purchase_limit',
        'start_time',
        'end_time',
        'status',
    ];
    public function approvedProducts()
    {
        return $this->hasMany(FlashSaleProduct::class)->where('status', 'approved');
    }
    public function products()
    {
        return $this->hasMany(FlashSaleProduct::class);
    }
}
