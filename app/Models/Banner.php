<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'store_id',
        'title',
        'description',
        'background_image',
        'redirect_url',
        'status',
        'priority',
    ];
    public $translationKeys = [
        'title',
        'description'
    ];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function store()
    {
        return $this->belongsTo(ComMerchantStore::class);
    }
}
