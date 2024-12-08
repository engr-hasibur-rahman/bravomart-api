<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComOption extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'com_options';

    // Specify which fields can be mass assigned
    protected $fillable = ['option_name', 'option_value', 'autoload'];

    public $translationKeys = [
        'option_name','com_site_title','com_site_subtitle'
    ];
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public $timestamps = true;
}
