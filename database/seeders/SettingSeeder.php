<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
//            ['option_name' => 'com_name', 'option_value' => json_encode(['com_name' => 'BIVA Mart']), 'autoload' => true],
//            ['option_name' => 'com_email', 'option_value' => json_encode(['com_email' => 'bivamart@bivasoft.com']), 'autoload' => true],
//            ['option_name' => 'com_phone', 'option_value' => json_encode(['com_phone' => '+1 817-000-0000']), 'autoload' => true],
//            ['option_name' => 'com_country', 'option_value' => json_encode(['com_country' => 'us']), 'autoload' => true],
//            ['option_name' => 'com_address', 'option_value' => json_encode(['com_address' => 'XXXX E Southlake Blvd, Southlake, TX 76092, United States']), 'autoload' => true],
//            ['option_name' => 'com_logo', 'option_value' => json_encode(['com_logo' => 'biva_logo.svg']), 'autoload' => true],
//            ['option_name' => 'com_logo_dark', 'option_value' => json_encode(['com_logo_dark' => 'biva_logo_dark.svg']), 'autoload' => true],
//            ['option_name' => 'com_logo_fav', 'option_value' => json_encode(['com_logo_fav' => 'biva_logo_fav.ico']), 'autoload' => true],
//            ['option_name' => 'com_logo_fav_dark', 'option_value' => json_encode(['com_logo_fav_dark' => 'biva_logo_fav_dark.ico']), 'autoload' => true],
//            ['option_name' => 'com_currency', 'option_value' => json_encode(['com_currency' => 'USD']), 'autoload' => true],
//            ['option_name' => 'com_currency_symb_position', 'option_value' => json_encode(['com_currency_symb_position' => '$']), 'autoload' => true],
//            ['option_name' => 'com_decimal_points', 'option_value' => json_encode(['com_decimal_points' => 2]), 'autoload' => true],
//            ['option_name' => 'com_text_copy_right', 'option_value' => json_encode(['com_text_copy_right' => 'Copyright @BivaMart Ltd.']), 'autoload' => true],
//            ['option_name' => 'com_text_cookies', 'option_value' => json_encode(['com_text_cookies' => '<h1>We use cookies<h1>
//
//Cookies help us deliver the best experience on our website. By using our website, you agree to the use of cookies. <a href="#">Find out how we use cookies</a>.']), 'autoload' => true],
//            ['option_name' => 'com_commi_rate_order', 'option_value' => json_encode(['com_commi_rate_order' => 10]), 'autoload' => true],
//            ['option_name' => 'com_commi_rate_deli_charge', 'option_value' => json_encode(['com_commi_rate_deli_charge' => 15]), 'autoload' => true],
//            ['option_name' => 'com_value_included_vat', 'option_value' => json_encode(['com_value_included_vat' => true]), 'autoload' => true],
//            ['option_name' => 'com_address', 'option_value' => json_encode(['com_address' => 'us']), 'autoload' => true],
//            ['option_name' => 'com_shipping_charge_min', 'option_value' => json_encode(['com_shipping_charge_min' => 30]), 'autoload' => true],

        ];

        DB::table('com_options')->insert($data);
    }
}
