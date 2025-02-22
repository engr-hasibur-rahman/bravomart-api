<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = ['name', 'subject', 'body', 'status'];

    protected $casts = [
        'status' => 'string',
        'body' => 'string',
    ];
}
