<?php

namespace Database\Seeders;

use App\Enums\Behaviour;
use App\Enums\StatusType;
use App\Enums\StoreType;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductVariant;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // You can customize this to use actual categories, brands, etc.
        $categories = ProductCategory::pluck('id')->toArray();
        $brands = ProductBrand::pluck('id')->toArray();
        $units = Unit::pluck('id')->toArray();
        $behaviours = Behaviour::cases();
        $types = StoreType::cases();  // Get all the cases of StoreType
        $randomType = $types[array_rand($types)]->value;  // Get a random enum value

        // Loop to create 100 products
        for ($i = 1; $i <= 100; $i++) {
            $product = Product::create([
                'store_id' => rand(1, 10), // Assuming you have multiple stores
                'category_id' => $categories[array_rand($categories)],
                'brand_id' => $brands[array_rand($brands)],
                'unit_id' => $units[array_rand($units)],
                'type' => $randomType,  // Use the valid enum value
                'behaviour' => $behaviours[array_rand($behaviours)]->value, // Random valid behaviour
                'name' => "Product $i",
                'slug' => "product-$i",
                'description' => "Description for product $i",
                'image' => "product$i.jpg",
                'warranty' => json_encode([
                    ['warranty_period' => rand(1, 5), 'warranty_text' => 'Years Warranty']
                ]),
                'class' => 'default',
                'return_in_days' => rand(7, 30),
                'return_text' => 'Return within the specified days.',
                'allow_change_in_mind' => 'Yes',
                'cash_on_delivery' => rand(0, 1) * 100, // Random COD availability
                'delivery_time_min' => rand(1, 2),
                'delivery_time_max' => rand(3, 7),
                'delivery_time_text' => 'Can be delayed during holidays.',
                'max_cart_qty' => rand(1, 10),
                'order_count' => rand(0, 100),
                'views' => rand(0, 1000),
                'status' => StatusType::cases()[array_rand(StatusType::cases())]->value, // Random status
                'meta_title' => "Meta Title for Product $i",
                'meta_description' => "Meta Description for Product $i",
                'meta_keywords' => "product, example, $i",
                'meta_image' => "product$i-meta.jpg",
                'available_time_starts' => now(),
                'available_time_ends' => now()->addDays(30),
            ]);

            // Create 3 product variants for each product
            for ($j = 1; $j <= 3; $j++) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_slug' => "product-$i-variant-$j",
                    'sku' => "SKU-{$i}-{$j}",
                    'pack_quantity' => rand(1, 10),
                    'weight_major' => rand(100, 500),
                    'weight_gross' => rand(500, 1000),
                    'weight_net' => rand(400, 900),
                    'color' => $this->getRandomColor(),
                    'size' => $this->getRandomSize(),
                    'price' => rand(100, 1000),
                    'special_price' => rand(50, 500),
                    'stock_quantity' => rand(10, 100),
                    'unit_id' => $product->unit_id,
                    'length' => rand(10, 50),
                    'width' => rand(10, 50),
                    'height' => rand(10, 50),
                    'image' => json_encode([
                        ['sliding_image' => "product{$i}-variant{$j}.jpg", 'position' => 1]
                    ]),
                    'order_count' => rand(0, 100),
                    'status' => rand(0, 1), // Random active/inactive
                ]);
            }
        }


    }


    /**
     * Helper function to get random color.
     */
    private function getRandomColor()
    {
        $colors = ['red', 'blue', 'green', 'yellow', 'black', 'white'];
        return $colors[array_rand($colors)];
    }

    /**
     * Helper function to get random size.
     */
    private function getRandomSize()
    {
        $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
        return $sizes[array_rand($sizes)];
    }

}
