<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class ComArea extends Model
{
    use HasFactory;

    //Will Manage Shop Area
    protected $table = 'com_areas';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'code',
        'coordinates',
    ];
    protected $casts = [
        'coordinates' => Polygon::class,
    ];
    public $translationKeys = [
        'name'
    ];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function stores()
    {
        return $this->hasMany(ComMerchantStore::class, 'area_id');
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class, 'area_id');
    }

    // Method to get translation by language and key
    public function getTranslation(string $key, string $language)
    {
        return $this->translations()->where('language', $language)->where('key', $key)->first()->value ?? null;
    }
}
