<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCommentReaction extends Model
{
    protected $fillable = [
        'blog_comment_id', 'user_id', 'reaction_type'
    ];

    public function user()
    {
        return $this->belongsTo(Customer::class);
    }

    public function blogComment()
    {
        return $this->belongsTo(BlogComment::class);
    }
}
