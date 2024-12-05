<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        "title",
        "code",
        "discount_type",
        "discount",
        "product_id",
        "start_date",
        "end_date",
        "usage_limit",
        "usage_count",
        "description",
        "status",
    ];
    public $translationKeys = [
        'title',
        'description'
    ];
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }
}
