<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'name', 'state_id', 'status',
    ];

    public function state(): belongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function areas(): hasMany
    {
        return $this->hasMany(Area::class);
    }
}
