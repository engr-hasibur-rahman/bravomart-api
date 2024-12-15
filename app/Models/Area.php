<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Area extends Model
{
    protected $fillable = [
        'name', 'city_id', 'status',
    ];

    public function city(): belongsTo
    {
        return $this->belongsTo(City::class);
    }
}
