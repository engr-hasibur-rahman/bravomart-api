<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'flash_sale_id', 'product_id', 'store_id', 'creator_type', 'created_by', 'updated_by',
    ];

    public function flashSale()
    {
        return $this->belongsTo(FlashSale::class, 'flash_sale_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Assumes a Product model exists
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
