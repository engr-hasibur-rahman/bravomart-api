<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'image',
        'button_text',
        'button_url',
        'redirect_url',
        'order',
        'status',
        'created_by',
        'updated_by'
    ];
    public $translationKeys = [
        'title',
        'sub_title',
        'description',
        'button_text',
    ];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }
}
