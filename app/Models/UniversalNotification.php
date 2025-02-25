<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversalNotification extends Model
{

    protected $fillable = [
        'user_id', 'title', 'message', 'data', 'notifiable_type', 'status'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    // Scopes for filtering notifications by type
    public function scopeForAdmins($query)
    {
        return $query->where('notifiable_type', 'admin');
    }

    public function scopeForStores($query)
    {
        return $query->where('notifiable_type', 'store');
    }

    public function scopeForCustomers($query)
    {
        return $query->where('notifiable_type', 'customer');
    }

    public function scopeForDeliverymen($query)
    {
        return $query->where('notifiable_type', 'deliveryman');
    }
}
