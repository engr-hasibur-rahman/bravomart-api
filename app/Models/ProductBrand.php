<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;

class ProductBrand extends Model
{
    use HasFactory;

    protected $table = 'product_brand';

    protected $guarded = [];

     // Single media file (e.g., brand logo)
     public function image(): MorphOne
     {
         return $this->morphOne(Media::class, 'fileable');
     }
 
     // Multiple media files (e.g., product photos)
     public function media()
     {
         return $this->morphMany(Media::class, 'fileable');
     }
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    // Method to get translation by language and key
    public function getTranslation(string $key, string $language)
    {
        return $this->translations()->where('language', $language)->where('key', $key)->first()->value ?? null;
    }
}
