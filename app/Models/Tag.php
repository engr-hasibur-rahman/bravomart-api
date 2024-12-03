<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        "name",
        "order",
        "created_by"
    ];
    public $translationKeys = [
        'name'
    ];
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }
}
