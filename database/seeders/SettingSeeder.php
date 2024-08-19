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
        DB::table('settings')->insert([
            'options' => json_encode([
                "useMustVerifyEmail" => false,
                "siteTitle" => "Biva Mart",
                "copyrightText" =>  "Copyright © Biva Mart. All rights reserved worldwide.",
            ]),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "language" => DEFAULT_LANGUAGE ?? "en",
        ]);
    }
}
