<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Main store categories with their subcategories
        $storeTypes = [
            'Food' => [
                'Fruits & Vegetables' => ['Fresh', 'Organic', 'Frozen'],
                'Dairy' => ['Milk', 'Cheese', 'Yogurt', 'Butter'],
                'Beverages' => ['Juice', 'Soda', 'Water', 'Energy Drinks'],
                'Snacks' => ['Chips', 'Cookies', 'Candy', 'Nuts'],
                'Meat & Seafood' => ['Chicken', 'Beef', 'Salmon', 'Shrimp'],
            ],

            'Cleaning & Household' => [
                'Dishwashing Supplies',
                'Laundry',
                'Toilet Cleaners',
                'Napkins & Paper Products',
                'Pest Control',
                'Floor & Glass Cleaners',
                'Trash Bin & Basket'
            ],

            'Personal Care' => [
                'Toothpaste', 'Shampoo', 'Soap', 'Body Wash', 'Hair Oil', 'Deodorant'
            ],
        ];

        // Loop through each store type and insert categories
        foreach ($storeTypes as $storeType => $subcategories) {
            // Insert the main category (store type)
            $parent_id = DB::table('product_category')->insertGetId([
                'category_name' => ucfirst(strtolower($storeType)),
                'category_slug' => strtolower($storeType),
                'category_level' => 1,
                'is_featured' => 1,
                'admin_commission_rate' => 10,
                'meta_title' => ucfirst(strtolower($storeType)),
                'meta_description' => ucfirst(strtolower($storeType)),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert subcategories (level 2)
            foreach ($subcategories as $subcategory => $subSubcategories) {
                $subcategory_id = DB::table('product_category')->insertGetId([
                    'category_name' => ucfirst(strtolower($subcategory)),
                    'category_slug' => strtolower(str_replace(' ', '-', $subcategory)),
                    'parent_id' => $parent_id,
                    'category_level' => 2,
                    'is_featured' => 1,
                    'admin_commission_rate' => 10,
                    'meta_title' => ucfirst(strtolower($subcategory)),
                    'meta_description' => ucfirst(strtolower($subcategory)),
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert sub-subcategories (level 3) if they exist
                if (is_array($subSubcategories)) {
                    foreach ($subSubcategories as $subSubcategory) {
                        DB::table('product_category')->insert([
                            'category_name' => ucfirst(strtolower($subSubcategory)),
                            'category_slug' => strtolower(str_replace(' ', '-', $subSubcategory)),
                            'parent_id' => $subcategory_id,
                            'category_level' => 3,
                            'is_featured' => 1,
                            'admin_commission_rate' => 10,
                            'meta_title' => ucfirst(strtolower($subSubcategory)),
                            'meta_description' => ucfirst(strtolower($subSubcategory)),
                            'status' => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
