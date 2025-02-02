<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'user_id',
        'store_id',
        'title',
        'description',
        'background_image',
        'thumbnail_image',
        'button_text',
        'button_color',
        'redirect_url',
        'location',
        'type',
        'status',
    ];
    public $translationKeys = [
        'title',
        'description',
        'button_text'
    ];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
    public function creator(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }
}
