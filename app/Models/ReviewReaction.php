<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewReaction extends Model
{
    protected $fillable = ['review_id', 'user_id', 'reaction_type'];
}
