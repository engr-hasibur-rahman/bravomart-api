<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryMan extends Model
{
    protected $fillable = [
        'user_id',
        'store_id',
        'vehicle_type_id',
        'area_id',
        'identification_type',
        'identification_number',
        'identification_photo_front',
        'identification_photo_back',
        'address',
        'created_by',
        'updated_by',
    ];

    public function deliveryman()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class,'reviewable');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function scopePendingDeliveryman($query)
    {
        return $query->whereHas('deliveryman', function ($q) {
            $q->where('status', 0)
                ->where('activity_scope', 'delivery_level');
        });
    }

    public function vehicle_type()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function area()
    {
        return $this->belongsTo(StoreArea::class, 'area_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
