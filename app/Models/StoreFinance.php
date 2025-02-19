<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreFinance extends Model
{
    protected $fillable = [
        'store_id', 'current_balance', 'earnings', 'withdrawn', 'refunds',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
