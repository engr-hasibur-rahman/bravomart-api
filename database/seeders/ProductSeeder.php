<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert the product
        $productId = DB::table('products')->insertGetId([
            "store_id" => "1",
            "category_id" => "1",
            "brand_id" => "1",
            "unit_id" => "1",
            "type" => "books",
            "behaviour" => "product",
            "name" => "Test Product",
            "slug" => "test-product",
            "description" => "Test Description",
            "warranty" => "30 days",
            "return_in_days" => "15 days",
            "return_text" => "Test Return Text",
            "allow_change_in_mind" => "Test Allow Change In Mind",
            "cash_on_delivery" => "200",
            "delivery_time_min" => "2 days",
            "delivery_time_max" => "7 days",
            "delivery_time_text" => "Test Delivery Time Text",
            "image" => "",
            "gallery_images" => "",
            "max_cart_qty" => "1000",
            "order_count" => 0,
            "views" => 0,
            "status" => "pending",
            "available_time_starts" => "2024-12-12",
            "available_time_ends" => "2025-01-12",
        ]);

        // Insert the variants
        $variants = [
            [
                "product_id" => $productId, // Associate with the product
                "variant_slug" => "Seeder-1",
                "pack_quantity" => "200",
                "weight_major" => "100.80",
                "weight_gross" => "72.50",
                "weight_net" => "72",
                "color" => "Red",
                "size" => "XL",
                "price" => "550",
                "special_price" => "500",
                "stock_quantity" => "200",
                "unit_id" => "1",
                "length" => "500",
                "width" => "120",
                "height" => "120",
                "image" => "",
                "order_count" => "1",
                "status" => "1",
            ],
            [
                "product_id" => $productId, // Associate with the product
                "variant_slug" => "Seeder-2",
                "pack_quantity" => "200",
                "weight_major" => "100.80",
                "weight_gross" => "72.50",
                "weight_net" => "72",
                "color" => "Red",
                "size" => "XL",
                "price" => "550",
                "special_price" => "500",
                "stock_quantity" => "5000",
                "unit_id" => "1",
                "length" => "500",
                "width" => "120",
                "height" => "120",
                "image" => "",
                "order_count" => "1",
                "status" => "1",
            ],
        ];

        DB::table('product_variants')->insert($variants);
        $productTags = [];
        $tags = ["1", "2"];
        foreach ($tags as $tagId) {
            $productTags[] = [
                'product_id' => $productId,
                'tag_id' => $tagId,
            ];
        }
        DB::table('product_tags')->insert($productTags);
        // Insert the translations
        $translations = [
            [
                "translatable_id" => $productId,
                "translatable_type" => "App\Models\Product",
                "language" => "en",
                "key" => json_encode(["name", "description"]),
                "value" => json_encode(["Test Name E5", "Test Description E5"]),
            ],
            [
                "translatable_id" => $productId,
                "translatable_type" => "App\Models\Product",
                "language" => "ar",
                "key" => json_encode(["name", "description"]),
                "value" => json_encode(["Test Name AR5", "Test Description AR5"]),
            ],
        ];

        DB::table('translations')->insert($translations);
    }
}
