<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAuthor extends Model
{
    use HasFactory;
    protected $table = 'product_authors';
    protected $fillable = [
        "profile_image",
        "cover_image",
        "name",
        "slug",
        "bio",
        "born_date",
        "death_date",
        "status",
    ];
    public $translationKeys = [
        'name'
    ];
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

}
