<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{

    protected $table = 'media';
    use HasFactory;
    protected $fillable = [
        'user_id',
        'format',
        'title',
        'file_size',
        'alt_text',
        'path',
        'dimensions'
    ];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
