<?php

namespace Database\Seeders;

use App\Enums\StoreType;
use App\Helpers\MultilangSlug;
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
            $attributeNames = $this->getAttributeNames($storeType->value); // Get attribute names based on type

            foreach ($attributeNames as $attributeName) {
                // Create an attribute for the current store type
                $productAttribute = ProductAttribute::firstOrCreate(
                    [
                        'name' => $attributeName,
                        'product_type' => $storeType->value,
                    ],
                    [
                        'status' => 1,
                        'created_by' => rand(1, 10),
                        'updated_by' => rand(1, 10),
                        'created_at' => $currentTimestamp,
                        'updated_at' => $currentTimestamp,
                    ]
                );

                // Add multiple values for the attribute
                for ($i = 1; $i <= 5; $i++) {
                    $data[] = [
                        'attribute_id' => $productAttribute->id,
                        'value' => $attributeName . "_Value_$i", // e.g., "Fish Name_Value_1"
                        'created_at' => $currentTimestamp,
                        'updated_at' => $currentTimestamp,
                    ];
                }
            }
        }

        ProductAttributeValue::insert($data);
    }

    private function getAttributeNames(string $storeType): array
    {
        $attributes = [
            'fish' => ['Fish Name', 'Fish Size', 'Fish Location'],
            'grocery' => ['Brand', 'Packaging Size', 'Expiry Date'],
            'bakery' => ['Flavor', 'Weight', 'Packaging Type'],
            'medicine' => ['Dosage', 'Manufacturer', 'Expiry Date'],
            'makeup' => ['Shade', 'Volume', 'Skin Type'],
            'bags' => ['Material', 'Size', 'Color'],
            'clothing' => ['Size', 'Color', 'Material'],
            'furniture' => ['Material', 'Dimensions', 'Weight Capacity'],
            'books' => ['Author', 'Genre', 'Language'],
            'gadgets' => ['Brand', 'Model', 'Specifications'],
            'animals-pet' => ['Breed', 'Age', 'Size'],
        ];

        return $attributes[$storeType] ?? ['Default Attribute'];
    }

}
