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
        'option_name','com_site_title','com_site_subtitle','com_meta_title', 'com_meta_description', 'com_meta_tags','com_og_title', 'com_og_description',
        'com_maintenance_title', 'com_maintenance_description', 'com_site_full_address','com_site_contact_number', 'com_site_footer_copyright',
    ];
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public $timestamps = true;
}
