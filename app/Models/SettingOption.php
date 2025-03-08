<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingOption extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'setting_options';

    // Specify which fields can be mass assigned
    protected $fillable = ['option_name', 'option_value', 'autoload'];

    public $translationKeys = [
        'option_name','com_site_title','com_site_subtitle','com_meta_title', 'com_meta_description', 'com_meta_tags','com_og_title', 'com_og_description',
        'com_maintenance_title', 'com_maintenance_description', 'com_site_full_address','com_site_contact_number', 'com_site_footer_copyright',
        'com_register_page_title', 'com_register_page_subtitle', 'com_register_page_description', 'com_register_page_terms_title',
    ];
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public $timestamps = true;
}
