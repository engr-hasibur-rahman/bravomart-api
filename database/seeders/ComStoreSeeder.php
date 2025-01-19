<?php

namespace Database\Seeders;

use App\Enums\StoreType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class
ComStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $storeTypes = array_map(fn($enum) => $enum->value, StoreType::cases());

        DB::table('com_merchant_stores')->insert([
            [
                'area_id' => 1,
                'merchant_id' => 1,
                'store_type' => $storeTypes[array_rand($storeTypes)],
                'name' => 'Store One',
                'slug' => Str::slug('Store One'),
                'phone' => '1234567890',
                'email' => 'storeone@example.com',
                'logo' => 'store_one_logo.png',
                'banner' => 'store_one_banner.png',
                'address' => '123 Main Street, City',
                'vat_tax_number' => 'VAT123456',
                'is_featured' => true,
                'opening_time' => '08:00:00',
                'closing_time' => '22:00:00',
                'subscription_type' => 'premium',
                'admin_commission_type' => 'percent',
                'admin_commission_amount' => 10.00,
                'delivery_charge' => 5.00,
                'delivery_time' => '30-60 minutes',
                'delivery_self_system' => true,
                'delivery_take_away' => true,
                'order_minimum' => 50,
                'veg_status' => 1,
                'off_day' => 'Sunday',
                'enable_saling' => 1,
                'meta_title' => 'Store One Meta Title',
                'meta_description' => 'Meta description for Store One.',
                'meta_image' => 'store_one_meta_image.png',
                'latitude' => "90.4584",
                'longitude' => "90.4584",
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'area_id' => 2,
                'merchant_id' => 2,
                'store_type' => $storeTypes[array_rand($storeTypes)],
                'name' => 'Store Two',
                'slug' => Str::slug('Store Two'),
                'phone' => '0987654321',
                'email' => 'storetwo@example.com',
                'logo' => 'store_two_logo.png',
                'banner' => 'store_two_banner.png',
                'address' => '456 Market Road, City',
                'vat_tax_number' => 'VAT654321',
                'is_featured' => false,
                'opening_time' => '09:00:00',
                'closing_time' => '21:00:00',
                'subscription_type' => 'standard',
                'admin_commission_type' => 'amount',
                'admin_commission_amount' => 20.00,
                'delivery_charge' => 3.00,
                'delivery_time' => '45-90 minutes',
                'delivery_self_system' => false,
                'delivery_take_away' => true,
                'order_minimum' => 30,
                'veg_status' => 0,
                'off_day' => 'Saturday',
                'enable_saling' => 1,
                'meta_title' => 'Store Two Meta Title',
                'meta_description' => 'Meta description for Store Two.',
                'meta_image' => 'store_two_meta_image.png',
                'latitude' => "90.4584",
                'longitude' => "90.4584",
                'status' => 1,
                'created_by' => 2,
                'updated_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
