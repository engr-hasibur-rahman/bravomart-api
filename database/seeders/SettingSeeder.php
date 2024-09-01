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
            ['option_name' => 'com_name', 'option_value' => json_encode(['com_name' => 'BIVA Mart']), 'autoload' => true],
            ['option_name' => 'com_email', 'option_value' => json_encode(['com_email' => 'bivamart@bivasoft.com']), 'autoload' => true],
            
        ];

        DB::table('com_options')->insert($data);
    }
}
