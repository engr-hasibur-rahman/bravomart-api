<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('store_areas')->updateOrInsert(
            ['id' => 1],
            [
                'code' => 'NY-001',
                'name' => 'Manhattan',
                'coordinates' => DB::raw("ST_GeomFromText('POLYGON((-73.985428 40.748817, -73.985428 40.748818, -73.985429 40.748818, -73.985429 40.748817, -73.985428 40.748817))')"),
                'status' => 1,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => '2024-11-16 04:50:33',
                'updated_at' => '2024-11-16 04:50:33',
            ]
        );
    }
}
