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
        'discount_amount',
        'special_price',
        'purchase_limit',
        'start_time',
        'end_time',
        'status',
    ];
    public $translationKeys = [
        'title',
        'description',
    ];

    public function approvedProducts()
    {
        return $this->hasMany(FlashSaleProduct::class)->where('status', 'approved');
    }

    public function products()
    {
        return $this->hasMany(FlashSaleProduct::class);
    }

    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }
}
