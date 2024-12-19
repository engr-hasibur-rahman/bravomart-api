<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banners')->insert([
            [
                'store_id' => 1,
                'title' => 'Winter Sale',
                'description' => 'Get up to 50% off on winter collections.',
                'background_image' => 'winter_sale.jpg',
                'redirect_url' => 'https://example.com/winter-sale',
                'status' => 1, // Active
                'priority' => 10,
            ],
            [
                'store_id' => 2,
                'title' => 'Summer Clearance',
                'description' => 'End of summer clearance with huge discounts.',
                'background_image' => 'summer_clearance.jpg',
                'redirect_url' => 'https://example.com/summer-clearance',
                'status' => 1, // Active
                'priority' => 8,
            ],
            [
                'store_id' => 3,
                'title' => 'New Year Special',
                'description' => 'Ring in the New Year with amazing deals.',
                'background_image' => 'new_year_special.jpg',
                'redirect_url' => null, // No redirect URL
                'status' => 0, // Inactive
                'priority' => 5,
            ],
        ]);
    }
}
