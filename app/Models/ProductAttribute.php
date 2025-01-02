<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;


    protected $table = 'product_attributes';

    protected $guarded = [];
    public $translationKeys = [
        'name'
    ];

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class, 'attribute_id');
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
