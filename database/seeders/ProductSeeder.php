<?php

namespace Database\Seeders;

use App\Enums\Behaviour;
use App\Enums\StatusType;
use App\Enums\StoreType;
use App\Models\Store;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductVariant;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch store IDs from the stores table
        $stores = Store::pluck('id')->toArray(); // Get store IDs as an array
        // You can customize this to use actual categories, brands, etc.
        $categories = ProductCategory::pluck('id')->toArray();
        $brands = ProductBrand::pluck('id')->toArray();
        $units = Unit::pluck('id')->toArray();  // Converts the collection to an array
        $behaviours = Behaviour::cases();
        $types = StoreType::cases();  // Get all the cases of StoreType
        $randomType = $types[array_rand($types)]->value;  // Get a random enum value

        // Example attribute sets for different types
        $attributes_sets = [
            'grocery' => [
                'brand' => ['Brand A', 'Brand B', 'Brand C'],
                'expiry_date' => ['2025-12-31', '2026-06-30', '2027-01-01'],
                'packaging_size' => ['Small', 'Medium', 'Large']
            ],
            'bakery' => [
                'flavor' => ['Vanilla', 'Chocolate', 'Strawberry'],
                'weight' => ['500g', '1kg', '2kg'],
                'packaging_type' => ['Box', 'Bag', 'Plastic']
            ],
            'medicine' => [
                'dosage' => ['50mg', '100mg', '200mg'],
                'manufacturer' => ['Company A', 'Company B'],
                'expiry_date' => ['2025-12-31', '2026-06-30']
            ],
            'makeup' => [
                'shade' => ['Light', 'Medium', 'Dark'],
                'volume' => ['30ml', '50ml', '100ml'],
                'skin_type' => ['Oily', 'Dry', 'Combination']
            ],
            'clothing' => [
                'color' => ['Red', 'Blue', 'Green', 'Black', 'White'],
                'size' => ['S', 'M', 'L', 'XL', 'XXL'],
                'material' => ['Cotton', 'Leather', 'Polyester']
            ],
            'bags' => [
                'material' => ['Leather', 'Canvas', 'Nylon'],
                'size' => ['Small', 'Medium', 'Large'],
                'color' => ['Red', 'Blue', 'Black', 'Brown']
            ],
            'furniture' => [
                'material' => ['Wood', 'Metal', 'Plastic'],
                'dimensions' => ['100x50x30', '150x75x50', '200x100x75'],
                'weight_capacity' => ['50kg', '100kg', '200kg']
            ],
            'books' => [
                'author' => ['Author A', 'Author B', 'Author C'],
                'genre' => ['Fiction', 'Non-fiction', 'Sci-fi'],
                'language' => ['English', 'Spanish', 'French']
            ],
            'gadgets' => [
                'brand' => ['Brand A', 'Brand B', 'Brand C'],
                'model' => ['Model X', 'Model Y', 'Model Z'],
                'specifications' => ['Spec 1', 'Spec 2', 'Spec 3']
            ],
            'animals-pet' => [
                'breed' => ['Breed A', 'Breed B', 'Breed C'],
                'age' => ['Puppy', 'Kitten', 'Adult'],
                'size' => ['Small', 'Medium', 'Large']
            ],
            'fish' => [
                'fish_name' => ['Salmon', 'Trout', 'Bass'],
                'fish_size' => ['Small', 'Medium', 'Large'],
                'fish_location' => ['Atlantic', 'Pacific', 'Indian Ocean']
            ],
        ];


        $products = [];
        $product_names = [
            "Fresh Apples", "Organic Bananas", "Whole Wheat Bread", "Almond Milk", "Organic Eggs", 
            "Fresh Carrots", "Tomato Sauce", "Instant Oatmeal", "Coconut Oil", "Frozen Chicken Breasts",
            "Rice Basmati", "Granola Bars", "Grape Juice", "Canned Tuna", "Cheddar Cheese",
            "Greek Yogurt", "Sweet Potatoes", "Frozen Broccoli", "Brown Sugar", "Pasta Spaghetti",
            "Whole Grain Crackers", "Peanut Butter", "Coconut Water", "Milk Chocolate", "Spinach Leaves",
            "Coffee Beans", "Frozen Pizza", "Vegetable Oil", "Mozzarella Cheese", "Honey",
            "Frozen French Fries", "Canned Corn", "Organic Almonds", "Mangoes", "Lemonade", 
            "Bottled Water", "Green Tea", "Frozen Strawberries", "Bag of Potatoes", "Hummus",
            "Flour", "Baking Powder", "Butter", "Tortilla Chips", "Canned Tomatoes", 
            "Balsamic Vinegar", "Ice Cream", "Wheat Flour", "Cereal", "Peach Jam"
        ];
        $brands = ['Nature\'s Best', 'Organic Valley', 'Great Harvest', 'Green Earth', 'Fresh Choice', 'Sunshine Farms'];
        $categories = ['Fresh Produce', 'Dairy', 'Snacks', 'Beverages', 'Frozen Food', 'Canned Goods', 'Bakery', 'Spices'];

        foreach ($categories as $category) {
            $products[] = ProductCategory::create([
                'category_name' => $category,  
                'category_slug' => Str::slug($category),  
                'category_name_paths' =>  $category,  
                'category_level' => 1,  
                'is_featured' => 1,  
                'meta_title' => $category.' Meta Title',
                'meta_description' => $category.' Meta Description',  
                'status' => 1,  
            ]);
        }
        foreach ($brands as $brand) {
            $products[] = ProductBrand::create([
                'brand_name' => $brand,  
                'brand_slug' => Str::slug($brand),  
                'display_order' => 1,
                'meta_title' => $brand.' Meta Title',
                'meta_description' => $brand.' Meta Description',  
                'status' => 1,  
            ]);
        }
        //dd($stores[array_rand($stores)]);
        $store_info = Store::select('id')->where('store_type', StoreType::GROCERY->value)->first();
        for ($i = 0; $i < 50; $i++) {
            $products[] = Product::create([
              // 'store_id' => $stores[array_rand($stores)],  
                'store_id' => $store_info->id,  
                //'store_id' => Store::where('id', 1)->select('id')->first()->value,  
                //Store::where('id', $request->store_id)->->first(),
                'category_id' => ProductCategory::where('category_name', $categories[array_rand($categories)])->select('id')->first()->value,
                //'brand_id' => $brands[array_rand($brands)],
                'brand_id' => ProductBrand::where('brand_name', $brands[array_rand($brands)])->select('id')->first()->value,
                'unit_id' => 1,  
                'type' => 'grocery',  
                'behaviour' => $behaviours[array_rand($behaviours)]->value, // Random valid behaviour
                'name' => $product_names[$i],  
                'slug' => strtolower(str_replace(' ', '-', $product_names[$i])),  
                'description' => "{$product_names[$i]} are fresh and of premium quality, perfect for your daily needs. Stock up and enjoy every bite!", 
                'image' => "1",  
                'warranty' => json_encode([
                    ['warranty_period' => rand(1, 5), 'warranty_text' => 'Years Warranty']
                ]),
                'class' => 'default',  
                'return_in_days' => rand(7, 30),  
                'return_text' => 'Return within the specified days.',  
                'allow_change_in_mind' => 'Yes',  
                'cash_on_delivery' => rand(0, 1) * 100,  
                'delivery_time_min' => rand(1, 2),  
                'delivery_time_max' => rand(3, 7),  
                'delivery_time_text' => 'Can be delayed during holidays.',
                'max_cart_qty' => rand(1, 10),  
                'order_count' => rand(0, 100),  
                'views' => rand(0, 1000),  
                'status' => StatusType::cases()[array_rand(StatusType::cases())]->value,  
                'meta_title' => "Buy {$product_names[$i]} online",  
                'meta_description' => "Order {$product_names[$i]} online and get fresh groceries delivered to your door.",
                'meta_keywords' => "grocery, {$product_names[$i]}, fresh, $i",
                'meta_image' => "grocery-product$i-meta.jpg",  
                'available_time_starts' => now(),  
                'available_time_ends' => now()->addDays(30),  
            ]);
        }



            $products = Product::all();
            $units = Unit::all();

            // Create 3 product variants for each product
            for ($j = 1; $j <= 3; $j++) {

                $product = $products->random();
                $unit = $units->random();

                // Get the product type
                $product_type = $product->type;

                // Get the appropriate attributes set based on product type
                $attributes = $attributes_sets[$product_type] ?? [];

                // Randomly select attributes
                $random_attributes = [];
                foreach ($attributes as $attribute => $options) {
                    $random_attributes[$attribute] = $options[array_rand($options)];
                }

                ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_slug' => "product-$i-variant-$j",
                    'sku' => "SKU-{$i}-{$j}",
                    'pack_quantity' => rand(1, 10),
                    'weight_major' => rand(100, 500),
                    'weight_gross' => rand(500, 1000),
                    'weight_net' => rand(400, 900),
                    'attributes' => json_encode($random_attributes), // Store as JSON
                    'price' => rand(100, 1000),
                    'special_price' => rand(50, 500),
                    'stock_quantity' => rand(10, 100),
                    'unit_id' => $unit->id,
                    'length' => rand(10, 50),
                    'width' => rand(10, 50),
                    'height' => rand(10, 50),
                    'image' => '2',
                    'order_count' => rand(0, 100),
                    'status' => rand(0, 1), // Random active/inactive
                ]);
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
