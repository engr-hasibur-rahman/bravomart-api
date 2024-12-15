<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = [
        'name', 'code', 'dial_code', 'latitude', 'longitude', 'timezone', 'region', 'languages', 'status',
    ];

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }
}
