<?php

namespace Database\Seeders;

use App\Enums\StoreType;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storeTypes = StoreType::cases(); // Fetch all store types from the enum
        $currentTimestamp = Carbon::now();
        $data = [];

        foreach ($storeTypes as $storeType) {
            // Ensure a ProductAttribute exists for each store type
            $productAttribute = ProductAttribute::firstOrCreate(
                ['name' => ucfirst($storeType->value)],
                [
                    'product_type' => $storeType->value,
                    'status' => 1,
                    'created_by' => rand(1, 10),
                    'updated_by' => rand(1, 10),
                    'created_at' => $currentTimestamp,
                    'updated_at' => $currentTimestamp,
                ]
            );

            // Add multiple values for the attribute
            for ($i = 1; $i <= 10; $i++) {
                $data[] = [
                    'attribute_id' => $productAttribute->id,
                    'value' => $storeType->value . "_Value_$i", // e.g., "grocery_Value_1"
                    'created_at' => $currentTimestamp,
                    'updated_at' => $currentTimestamp,
                ];
            }
        }

        ProductAttributeValue::insert($data);
    }
}
