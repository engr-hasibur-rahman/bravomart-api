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
//        // Store types
//        $storeTypes = [
//            'GROCERY' => ['Fruits', 'Dairy', 'Beverages', 'Snacks', 'Frozen', 'Meat & Seafood', 'Canned', 'Spices', 'Personal Care', 'Baking'],
//            'BAKERY' => ['Bread', 'Pastries', 'Cakes', 'Cookies', 'Muffins', 'Buns', 'Tarts', 'Pies', 'Bagels', 'Crostini'],
//            'MEDICINE' => ['Pain Relief', 'Cold & Cough', 'Vitamins', 'First Aid', 'Digestive', 'Allergy', 'Care', 'Skin Care', 'Eye Care', 'Devices'],
//            'MAKEUP' => ['Foundations', 'Lipsticks', 'Eyeshadows', 'Mascaras', 'Blushes', 'Highlighters', 'Primers', 'Concealers', 'Eyeliners', 'Nail Polishes'],
//            'BAGS' => ['Handbags', 'Totes', 'Backpacks', 'Laptop Bags', 'Wallets', 'Clutches', 'Crossbody', 'Duffels', 'Shoulder Bags', 'Briefcases'],
//            'CLOTHING' => ['T-Shirts', 'Jeans', 'Shirts', 'Sweaters', 'Jackets', 'Dresses', 'Skirts', 'Trousers', 'Shorts', 'Suits'],
//            'FURNITURE' => ['Sofas', 'Chairs', 'Beds', 'Tables', 'Dressers', 'Bookshelves', 'Desks', 'Cabinets', 'Lamps', 'Coffee Tables'],
//            'BOOKS' => ['Fiction', 'Non-Fiction', 'Sci-Fi', 'Fantasy', 'Romance', 'Biography', 'Cookbooks', 'History', 'Kids\' Books', 'Self-Help'],
//            'GADGET' => ['Phones', 'Tablets', 'Headphones', 'Smart Watches', 'Laptops', 'Cameras', 'Drones', 'Speakers', 'Chargers', 'Accessories'],
//            'ANIMALS_PET' => ['Dog Food', 'Cat Food', 'Pet Toys', 'Grooming', 'Accessories', 'Leashes', 'Pet Beds', 'Aquarium', 'Pet Supplements', 'Healthcare'],
//            'FISH' => ['Freshwater', 'Saltwater', 'Aquarium Plants', 'Aquarium Decor', 'Fish Food', 'Water Care', 'Filters', 'Tanks', 'Lighting', 'Heaters'],
//        ];

//        // Loop through each store type and insert categories
//        foreach ($storeTypes as $storeType => $categories) {
//            $parent_id = DB::table('product_category')->insertGetId([
//                'category_name' => ucfirst(strtolower($storeType)),
//                'category_slug' => strtolower($storeType),
//                'category_level' => 1,
//                'is_featured' => 1,
//                'admin_commission_rate' => 10,
//                'meta_title' => ucfirst(strtolower($storeType)),
//                'meta_description' => ucfirst(strtolower($storeType)),
//                'status' => 1,
//                'created_at' => now(),
//                'updated_at' => now(),
//            ]);
//            // Insert subcategories
//            foreach ($categories as $category) {
//                DB::table('product_category')->insert([
//                    'category_name' => $category,
//                    'category_slug' => strtolower(str_replace(' ', '-', $category)),
//                    'category_name_paths' => ucfirst(strtolower($storeType)),
//                    'parent_path' => strtolower($storeType),
//                    'parent_id' => $parent_id,
//                    'category_level' => 2,
//                    'is_featured' => 1,
//                    'admin_commission_rate' => 10,
//                    'meta_title' => $category,
//                    'meta_description' => $category,
//                    'status' => 1,
//                    'created_at' => now(),
//                    'updated_at' => now(),
//                ]);
//            }
//        }
    }

}
