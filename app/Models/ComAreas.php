<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class ComAreas extends Model
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'com_areas';

    protected $guarded = [];

   
}
