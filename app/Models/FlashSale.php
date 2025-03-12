<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_color',
        'description',
        'description_color',
        'button_text',
        'button_text_color',
        'button_hover_color',
        'button_bg_color',
        'button_url',
        'timer_bg_color',
        'timer_text_color',
        'image',
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
        'button_text'
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
