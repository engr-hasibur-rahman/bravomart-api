<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         \App\Models\User::create([
            'first_name' => 'Customer',
            'slug' => 'customer',
            'email' => 'customer@gmail.com',
            'activity_scope' => 'customer_level',
            'password' => Hash::make('customer123'),
             'status' => 1,
        ]);
    }
}
