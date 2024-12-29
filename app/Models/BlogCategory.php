<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $fillable = [
        "name",
        "slug",
        "meta_title",
        "meta_description",
        "status",
    ];
    public $translationKeys = [
        'name',
        'meta_title',
        'meta_description',
    ];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function blogs()
    {
        return $this->belongsToMany(Product::class);
    }
}
