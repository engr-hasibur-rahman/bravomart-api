<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $fillable = [
        "name",
        "status",
    ];
    public $translationKeys = [
        'name',
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
