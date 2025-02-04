<?php

namespace Database\Seeders;

use App\Models\StoreAreaRangeCharge;
use Illuminate\Database\Seeder;

class StoreAreaRangeWiseChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoreAreaRangeCharge::create([
            "store_area_id" => 1,
            "store_type_id" => 1,
            "min_km" => 0,
            "max_km" => 5,
            "charge_amount" => 5,
            "delivery_charge_method" => 'fixed',
            "status" => 1
        ]);

    }
}
