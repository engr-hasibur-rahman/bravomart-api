<?php

namespace App\Models;

use App\Traits\DeleteTranslations;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use DeleteTranslations;
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
    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }
}
