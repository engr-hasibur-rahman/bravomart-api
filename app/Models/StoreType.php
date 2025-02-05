<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreType extends Model
{
    protected $guarded = ['type'];
    protected $fillable = [
        'name',
        'image',
        'description',
        'total_stores',
        'status'
    ];
    public $translationKeys = [
        'name',
        'description',
    ];

    public function areaDetails()
    {
        return $this->belongsToMany(StoreAreaSetting::class, 'store_area_setting_store_types', 'store_type_id', 'store_area_setting_id')
            ->with(['rangeCharges']);
    }

    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }
}
