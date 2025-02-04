<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class StoreArea extends Model
{
    use HasFactory;

    //Will Manage Shop Area
    protected $table = 'store_areas';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'code',
        'coordinates',
        'store_type',
        'center_latitude',
        'center_longitude',
        'state',
        'city',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'coordinates' => Polygon::class,
    ];
    public $translationKeys = [
        'name',
        'state',
        'city',
    ];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'area_id');
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

    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }
}
