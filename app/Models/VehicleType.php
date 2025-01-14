<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'speed_range',
        'fuel_type',
        'max_distance',
        'extra_charge',
        'average_fuel_cost',
        'description',
        'status',
        'store_id',
        'created_by',
    ];
    public $translationKeys = [
        'name',
        'description'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function store()
    {
        return $this->belongsTo(ComMerchantStore::class, 'store_id');
    }
    public function scopeInactiveVehicles($query){
        $query->where('status', 0);
    }

    public function related_translations()
    {
        return $this->hasMany(Translation::class, 'translatable_id')
            ->where('translatable_type', self::class);
    }
}
