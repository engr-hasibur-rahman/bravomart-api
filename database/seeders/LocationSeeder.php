<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = \App\Models\Country::create([
            'name' => 'United States',
            'code' => 'US',
            'dial_code' => '+1',
            'latitude' => '37.0902',
            'longitude' => '-95.7129',
            'timezone' => 'America/New_York',
            'region' => 'North America',
            'languages' => 'English',
            'status' => 1,
        ]);

        $state = $country->states()->create([
            'name' => 'California',
            'timezone' => 'America/Los_Angeles',
            'status' => 1,
        ]);

        $city = $state->cities()->create([
            'name' => 'Los Angeles',
            'status' => 1,
        ]);

        $city->areas()->createMany([
            ['name' => 'Downtown', 'status' => 1],
            ['name' => 'Hollywood', 'status' => 1],
        ]);
    }
}
