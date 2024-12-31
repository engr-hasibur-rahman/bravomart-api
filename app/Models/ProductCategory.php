<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductCategory extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'product_category';

    protected $guarded = [];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    // Method to get translation by language and key
    public function getTranslation(string $key, string $language)
    {
        return $this->translations()->where('language', $language)->where('key', $key)->first()->value ?? null;
    }

    public function children() {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function childrenRecursive() {
        return $this->children()->with('childrenRecursive');
    }
}
