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
                'category_name_paths' => $category,
                'category_level' => 1,
                'is_featured' => 1,
                'meta_title' => $category . ' Meta Title',
                'meta_description' => $category . ' Meta Description',
                'status' => 1,
            ]);
        }
        foreach ($brands as $brand) {
            $products[] = ProductBrand::create([
                'brand_name' => $brand,
                'brand_slug' => Str::slug($brand),
                'display_order' => 1,
                'meta_title' => $brand . ' Meta Title',
                'meta_description' => $brand . ' Meta Description',
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

        $products = [];
        $product_names = [
            "Sourdough Bread", "French Baguette", "Multigrain Loaf", "Ciabatta Bread", "Rye Bread",
            "Croissants", "Butter Rolls", "Cinnamon Buns", "Chocolate Muffins", "Blueberry Scones",
            "Apple Turnovers", "Almond Danish", "Pumpkin Bread", "Banana Bread", "Whole Wheat Bagels",
            "Garlic Breadsticks", "Glazed Donuts", "Vanilla Pound Cake", "Red Velvet Cupcakes", "Carrot Cake"
        ];

        $brands = ['Nature\'s Best', 'Organic Valley', 'Great Harvest', 'Green Earth', 'Fresh Choice', 'Sunshine Farms'];
        $categories = ['Bakery'];

        $store_info = Store::select('id')->where('store_type', StoreType::GROCERY->value)->first();

        for ($i = 0; $i < count($product_names); $i++) {
            $products[] = Product::create([
                'store_id' => $store_info->id,
                'category_id' => ProductCategory::where('category_name', 'Bakery')->select('id')->first()->value,
                'brand_id' => ProductBrand::where('brand_name', $brands[array_rand($brands)])->select('id')->first()->value,
                'unit_id' => 1,
                'type' => 'bakery',
                'behaviour' => $behaviours[array_rand($behaviours)]->value, // Random valid behaviour
                'name' => $product_names[$i],
                'slug' => strtolower(str_replace(' ', '-', $product_names[$i])),
                'description' => "{$product_names[$i]} is freshly baked and of premium quality, perfect for your daily needs. Stock up and enjoy every bite!",
                'image' => "1",
                'warranty' => json_encode([
                    ['warranty_period' => rand(1, 5), 'warranty_text' => 'Days Warranty']
                ]),
                'class' => 'default',
                'return_in_days' => rand(1, 7),
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
                'meta_description' => "Order {$product_names[$i]} online and get freshly baked goods delivered to your door.",
                'meta_keywords' => "bakery, {$product_names[$i]}, fresh, $i",
                'meta_image' => "bakery-product$i-meta.jpg",
                'available_time_starts' => now(),
                'available_time_ends' => now()->addDays(30),
            ]);
        }

        $products = [];
        $product_names = [
            "Paracetamol Tablets", "Ibuprofen Capsules", "Aspirin 500mg", "Cetirizine Antihistamine", "Omeprazole 20mg",
            "Amoxicillin Antibiotic", "Cough Syrup", "Vitamin C Tablets", "Multivitamin Capsules", "Calcium Supplements",
            "Iron Tonic", "Antiseptic Cream", "Pain Relief Balm", "Loratadine Allergy Relief", "Dextromethorphan Syrup",
            "Throat Lozenges", "Antacid Chewable Tablets", "Antifungal Cream", "Digestive Enzyme Capsules", "Zinc Supplements"
        ];

        $brands = ['MediCare', 'PharmaLife', 'HealthGuard', 'Wellness Plus', 'PureMed', 'LifeSaver'];
        $categories = ['Medicine'];
        foreach ($categories as $category) {
            $products[] = ProductCategory::create([
                'category_name' => $category,
                'category_slug' => Str::slug($category),
                'category_name_paths' => $category,
                'category_level' => 1,
                'is_featured' => 1,
                'meta_title' => $category . ' Meta Title',
                'meta_description' => $category . ' Meta Description',
                'status' => 1,
            ]);
        }
        foreach ($brands as $brand) {
            $products[] = ProductBrand::create([
                'brand_name' => $brand,
                'brand_slug' => Str::slug($brand),
                'display_order' => 1,
                'meta_title' => $brand . ' Meta Title',
                'meta_description' => $brand . ' Meta Description',
                'status' => 1,
            ]);
        }

        $store_info = Store::select('id')->where('store_type', StoreType::MEDICINE->value)->first();

        for ($i = 0; $i < count($product_names); $i++) {
            $products[] = Product::create([
                'store_id' => $store_info->id,
                'category_id' => ProductCategory::where('category_name', 'Medicine')->select('id')->first()->value,
                'brand_id' => ProductBrand::where('brand_name', $brands[array_rand($brands)])->select('id')->first()->value,
                'unit_id' => 1,
                'type' => 'medicine',
                'behaviour' => $behaviours[array_rand($behaviours)]->value, // Random valid behaviour
                'name' => $product_names[$i],
                'slug' => strtolower(str_replace(' ', '-', $product_names[$i])),
                'description' => "{$product_names[$i]} is a high-quality pharmaceutical product designed for effective treatment and relief.",
                'image' => "1",
                'warranty' => json_encode([
                    ['warranty_period' => rand(1, 2), 'warranty_text' => 'Months Warranty']
                ]),
                'class' => 'default',
                'return_in_days' => rand(1, 14),  // Shorter return period for medicines
                'return_text' => 'Return within the specified days if the packaging is unopened.',
                'allow_change_in_mind' => 'No',  // Medicines typically cannot be returned after purchase
                'cash_on_delivery' => rand(0, 1) * 100,
                'delivery_time_min' => rand(1, 2),
                'delivery_time_max' => rand(3, 5),
                'delivery_time_text' => 'Delivery time may vary based on location and availability.',
                'max_cart_qty' => rand(1, 5),  // Limiting quantity for medicine purchases
                'order_count' => rand(0, 100),
                'views' => rand(0, 1000),
                'status' => StatusType::cases()[array_rand(StatusType::cases())]->value,
                'meta_title' => "Buy {$product_names[$i]} online",
                'meta_description' => "Order {$product_names[$i]} online and get quality medicines delivered safely to your home.",
                'meta_keywords' => "medicine, {$product_names[$i]}, healthcare, pharmacy, $i",
                'meta_image' => "medicine-product$i-meta.jpg",
                'available_time_starts' => now(),
                'available_time_ends' => now()->addDays(60),
            ]);
        }

        $products = [];
        $product_names = [
            "Liquid Foundation", "Matte Lipstick", "Waterproof Mascara", "Eyebrow Pomade", "Blush Palette",
            "Highlighter Stick", "BB Cream", "CC Cream", "Setting Spray", "Translucent Powder",
            "Eyeshadow Palette", "Gel Eyeliner", "Lip Gloss", "Compact Powder", "Makeup Primer",
            "Contour Kit", "Makeup Setting Powder", "Nude Lipstick", "Kajal Pencil", "Concealer Stick"
        ];

        $brands = ['GlamBeauty', 'RadiantGlow', 'PureCosmetics', 'VelvetTouch', 'LuxeMakeup', 'GlowEssentials'];
        $categories = ['Makeup'];
        foreach ($categories as $category) {
            $products[] = ProductCategory::create([
                'category_name' => $category,
                'category_slug' => Str::slug($category),
                'category_name_paths' => $category,
                'category_level' => 1,
                'is_featured' => 1,
                'meta_title' => $category . ' Meta Title',
                'meta_description' => $category . ' Meta Description',
                'status' => 1,
            ]);
        }
        foreach ($brands as $brand) {
            $products[] = ProductBrand::create([
                'brand_name' => $brand,
                'brand_slug' => Str::slug($brand),
                'display_order' => 1,
                'meta_title' => $brand . ' Meta Title',
                'meta_description' => $brand . ' Meta Description',
                'status' => 1,
            ]);
        }

        $store_info = Store::select('id')->where('store_type', StoreType::MAKEUP->value)->first();

        for ($i = 0; $i < count($product_names); $i++) {
            $products[] = Product::create([
                'store_id' => $store_info->id,
                'category_id' => ProductCategory::where('category_name', 'Makeup')->select('id')->first()->value,
                'brand_id' => ProductBrand::where('brand_name', $brands[array_rand($brands)])->select('id')->first()->value,
                'unit_id' => 1,
                'type' => 'makeup',
                'behaviour' => $behaviours[array_rand($behaviours)]->value, // Random valid behaviour
                'name' => $product_names[$i],
                'slug' => strtolower(str_replace(' ', '-', $product_names[$i])),
                'description' => "{$product_names[$i]} enhances your beauty with a flawless finish, designed for long-lasting wear.",
                'image' => "1",
                'warranty' => json_encode([
                    ['warranty_period' => rand(1, 2), 'warranty_text' => 'Months Warranty']
                ]),
                'class' => 'default',
                'return_in_days' => rand(7, 30),
                'return_text' => 'Return within the specified days if unopened and unused.',
                'allow_change_in_mind' => 'Yes',
                'cash_on_delivery' => rand(0, 1) * 100,
                'delivery_time_min' => rand(1, 2),
                'delivery_time_max' => rand(3, 7),
                'delivery_time_text' => 'Can be delayed during holidays.',
                'max_cart_qty' => rand(1, 5),  // Limited purchase for makeup items
                'order_count' => rand(0, 100),
                'views' => rand(0, 1000),
                'status' => StatusType::cases()[array_rand(StatusType::cases())]->value,
                'meta_title' => "Buy {$product_names[$i]} online",
                'meta_description' => "Order {$product_names[$i]} online and get premium beauty products delivered to your doorstep.",
                'meta_keywords' => "makeup, {$product_names[$i]}, beauty, cosmetics, $i",
                'meta_image' => "makeup-product$i-meta.jpg",
                'available_time_starts' => now(),
                'available_time_ends' => now()->addDays(60),
            ]);
        }
        $products = [];
        $product_names = [
            "Leather Messenger Bag", "Canvas Tote Bag", "Vintage Backpack", "Luxury Handbag", "Casual Sling Bag",
            "Crossbody Purse", "Travel Duffel Bag", "Gym Sports Bag", "Laptop Backpack", "Mini Shoulder Bag",
            "Rolling Suitcase", "Clutch Evening Bag", "Business Briefcase", "Hiking Rucksack", "Designer Satchel",
            "Drawstring Bag", "Eco-friendly Shopping Bag", "Convertible Backpack", "Belt Bag", "Waterproof Dry Bag"
        ];

        $brands = ['UrbanStyle', 'LuxuryLeather', 'NomadGear', 'ClassicCarry', 'EcoTote', 'TravelMate'];
        $categories = ['Bags'];
        foreach ($categories as $category) {
            $products[] = ProductCategory::create([
                'category_name' => $category,
                'category_slug' => Str::slug($category),
                'category_name_paths' => $category,
                'category_level' => 1,
                'is_featured' => 1,
                'meta_title' => $category . ' Meta Title',
                'meta_description' => $category . ' Meta Description',
                'status' => 1,
            ]);
        }
        foreach ($brands as $brand) {
            $products[] = ProductBrand::create([
                'brand_name' => $brand,
                'brand_slug' => Str::slug($brand),
                'display_order' => 1,
                'meta_title' => $brand . ' Meta Title',
                'meta_description' => $brand . ' Meta Description',
                'status' => 1,
            ]);
        }

        $store_info = Store::select('id')->where('store_type', StoreType::BAGS->value)->first();

        for ($i = 0; $i < count($product_names); $i++) {
            $products[] = Product::create([
                'store_id' => $store_info->id,
                'category_id' => ProductCategory::where('category_name', 'Bags')->select('id')->first()->value,
                'brand_id' => ProductBrand::where('brand_name', $brands[array_rand($brands)])->select('id')->first()->value,
                'unit_id' => 1,
                'type' => 'bags',
                'behaviour' => $behaviours[array_rand($behaviours)]->value, // Random valid behaviour
                'name' => $product_names[$i],
                'slug' => strtolower(str_replace(' ', '-', $product_names[$i])),
                'description' => "{$product_names[$i]} is stylish, durable, and perfect for your everyday needs.",
                'image' => "1",
                'warranty' => json_encode([
                    ['warranty_period' => rand(1, 5), 'warranty_text' => 'Years Warranty']
                ]),
                'class' => 'default',
                'return_in_days' => rand(7, 30),
                'return_text' => 'Return within the specified days if unused.',
                'allow_change_in_mind' => 'Yes',
                'cash_on_delivery' => rand(0, 1) * 100,
                'delivery_time_min' => rand(1, 2),
                'delivery_time_max' => rand(3, 7),
                'delivery_time_text' => 'Can be delayed during holidays.',
                'max_cart_qty' => rand(1, 5),  // Bags are usually purchased in limited quantities
                'order_count' => rand(0, 100),
                'views' => rand(0, 1000),
                'status' => StatusType::cases()[array_rand(StatusType::cases())]->value,
                'meta_title' => "Buy {$product_names[$i]} online",
                'meta_description' => "Order {$product_names[$i]} online and get high-quality bags delivered to your doorstep.",
                'meta_keywords' => "bags, {$product_names[$i]}, travel, fashion, accessories, $i",
                'meta_image' => "bag-product$i-meta.jpg",
                'available_time_starts' => now(),
                'available_time_ends' => now()->addDays(60),
            ]);
        }

        $products = [];
        $product_names = [
            "Classic White T-Shirt", "Slim Fit Jeans", "Cotton Polo Shirt", "Hooded Sweatshirt", "Casual Chino Pants",
            "Denim Jacket", "Athletic Joggers", "Formal Dress Shirt", "Wool Blend Coat", "Basic Crew Neck Sweater",
            "High-Waisted Leggings", "Summer Floral Dress", "Men's Cargo Shorts", "Winter Puffer Jacket", "Linen Button-Up Shirt",
            "Stretch Skinny Jeans", "V-Neck Sweater", "Waterproof Windbreaker", "Casual Blazer", "Lightweight Cardigan"
        ];

        $brands = ['UrbanWear', 'ClassicStyle', 'TrendyFit', 'LuxuryThreads', 'EcoFashion', 'StreetVogue'];
        $categories = ['Men', 'Women', 'Unisex', 'Formal', 'Casual', 'Sportswear', 'Outerwear'];
        foreach ($categories as $category) {
            $products[] = ProductCategory::create([
                'category_name' => $category,
                'category_slug' => Str::slug($category),
                'category_name_paths' => $category,
                'category_level' => 1,
                'is_featured' => 1,
                'meta_title' => $category . ' Meta Title',
                'meta_description' => $category . ' Meta Description',
                'status' => 1,
            ]);
        }
        foreach ($brands as $brand) {
            $products[] = ProductBrand::create([
                'brand_name' => $brand,
                'brand_slug' => Str::slug($brand),
                'display_order' => 1,
                'meta_title' => $brand . ' Meta Title',
                'meta_description' => $brand . ' Meta Description',
                'status' => 1,
            ]);
        }
        $store_info = Store::select('id')->where('store_type', StoreType::CLOTHING->value)->first();

        for ($i = 0; $i < count($product_names); $i++) {
            $products[] = Product::create([
                'store_id' => $store_info->id,
                'category_id' => ProductCategory::where('category_name', $categories[array_rand($categories)])->select('id')->first()->value,
                'brand_id' => ProductBrand::where('brand_name', $brands[array_rand($brands)])->select('id')->first()->value,
                'unit_id' => 1,
                'type' => 'clothing',
                'behaviour' => $behaviours[array_rand($behaviours)]->value, // Random valid behaviour
                'name' => $product_names[$i],
                'slug' => strtolower(str_replace(' ', '-', $product_names[$i])),
                'description' => "{$product_names[$i]} is stylish, comfortable, and perfect for your wardrobe.",
                'image' => "1",
                'warranty' => json_encode([
                    ['warranty_period' => rand(1, 2), 'warranty_text' => 'Months Warranty'] // Clothing usually has a shorter warranty
                ]),
                'class' => 'default',
                'return_in_days' => rand(7, 30),
                'return_text' => 'Return within the specified days if unworn.',
                'allow_change_in_mind' => 'Yes',
                'cash_on_delivery' => rand(0, 1) * 100,
                'delivery_time_min' => rand(1, 2),
                'delivery_time_max' => rand(3, 7),
                'delivery_time_text' => 'Delivery may take longer during peak seasons.',
                'max_cart_qty' => rand(1, 5),
                'order_count' => rand(0, 500),
                'views' => rand(0, 5000),
                'status' => StatusType::cases()[array_rand(StatusType::cases())]->value,
                'meta_title' => "Buy {$product_names[$i]} online",
                'meta_description' => "Order {$product_names[$i]} online and update your wardrobe with the latest fashion trends.",
                'meta_keywords' => "clothing, fashion, {$product_names[$i]}, apparel, $i",
                'meta_image' => "clothing-product$i-meta.jpg",
                'available_time_starts' => now(),
                'available_time_ends' => now()->addDays(60),
            ]);
        }

        $products = [];
        $product_names = [
            "Modern Wooden Dining Table", "Luxury Leather Sofa", "Classic Oak Wardrobe", "Adjustable Office Chair", "Minimalist Coffee Table",
            "Rustic TV Stand", "Velvet Accent Chair", "Glass Top Work Desk", "Queen Size Bed Frame", "Storage Ottoman Bench",
            "L-Shaped Sectional Sofa", "Mid-Century Bookshelf", "Convertible Sofa Bed", "Compact Shoe Rack", "Floating Wall Shelves",
            "Recliner Armchair", "Foldable Computer Desk", "Wooden Kitchen Cabinet", "Ergonomic Gaming Chair", "Bathroom Vanity Set"
        ];

        $brands = ['HomeElegance', 'ModernSpace', 'LuxuryLiving', 'CozyNest', 'UrbanFurnish', 'RusticCharm'];
        $categories = ['Furniture'];
        foreach ($brands as $brand) {
            $products[] = ProductBrand::create([
                'brand_name' => $brand,
                'brand_slug' => Str::slug($brand),
                'display_order' => 1,
                'meta_title' => $brand . ' Meta Title',
                'meta_description' => $brand . ' Meta Description',
                'status' => 1,
            ]);
        }
        $store_info = Store::select('id')->where('store_type', StoreType::FURNITURE->value)->first();

        for ($i = 0; $i < count($product_names); $i++) {
            $products[] = Product::create([
                'store_id' => $store_info->id,
                'category_id' => ProductCategory::where('category_name', $categories[array_rand($categories)])->select('id')->first()->value,
                'brand_id' => ProductBrand::where('brand_name', $brands[array_rand($brands)])->select('id')->first()->value,
                'unit_id' => 1,
                'type' => 'furniture',
                'behaviour' => $behaviours[array_rand($behaviours)]->value, // Random valid behaviour
                'name' => $product_names[$i],
                'slug' => strtolower(str_replace(' ', '-', $product_names[$i])),
                'description' => "{$product_names[$i]} is crafted with high-quality materials, offering durability and style for your space.",
                'image' => "1",
                'warranty' => json_encode([
                    ['warranty_period' => rand(1, 10), 'warranty_text' => 'Years Warranty'] // Longer warranty for furniture
                ]),
                'class' => 'default',
                'return_in_days' => rand(7, 30),
                'return_text' => 'Return within the specified days if unused and in original packaging.',
                'allow_change_in_mind' => 'Yes',
                'cash_on_delivery' => rand(0, 1) * 100,
                'delivery_time_min' => rand(3, 5),
                'delivery_time_max' => rand(7, 14),
                'delivery_time_text' => 'Delivery may take longer due to size and handling.',
                'max_cart_qty' => rand(1, 3),
                'order_count' => rand(0, 500),
                'views' => rand(0, 5000),
                'status' => StatusType::cases()[array_rand(StatusType::cases())]->value,
                'meta_title' => "Buy {$product_names[$i]} online",
                'meta_description' => "Order {$product_names[$i]} online and upgrade your home with premium furniture.",
                'meta_keywords' => "furniture, home decor, {$product_names[$i]}, interior design, $i",
                'meta_image' => "furniture-product$i-meta.jpg",
                'available_time_starts' => now(),
                'available_time_ends' => now()->addDays(90),
            ]);
        }


        $products = [];
        $product_names = [
            "The Art of War", "To Kill a Mockingbird", "1984", "Pride and Prejudice", "The Great Gatsby",
            "Moby Dick", "War and Peace", "Crime and Punishment", "The Catcher in the Rye", "The Hobbit",
            "The Odyssey", "Brave New World", "The Brothers Karamazov", "The Divine Comedy", "Ulysses",
            "One Hundred Years of Solitude", "The Picture of Dorian Gray", "The Jungle Book", "The Grapes of Wrath", "The Lord of the Rings"
        ];

        $brands = ['Penguin Classics', 'HarperCollins', 'Oxford University Press', 'Random House', 'Macmillan'];
        $categories = ['Fiction', 'Non-Fiction', 'Literature', 'Classics', 'Science Fiction', 'Fantasy', 'Biography', 'History'];
        foreach ($categories as $category) {
            $products[] = ProductCategory::create([
                'category_name' => $category,
                'category_slug' => Str::slug($category),
                'category_name_paths' => $category,
                'category_level' => 1,
                'is_featured' => 1,
                'meta_title' => $category . ' Meta Title',
                'meta_description' => $category . ' Meta Description',
                'status' => 1,
            ]);
        }
        foreach ($brands as $brand) {
            $products[] = ProductBrand::create([
                'brand_name' => $brand,
                'brand_slug' => Str::slug($brand),
                'display_order' => 1,
                'meta_title' => $brand . ' Meta Title',
                'meta_description' => $brand . ' Meta Description',
                'status' => 1,
            ]);
        }
        $store_info = Store::select('id')->where('store_type', StoreType::BOOKS->value)->first();

        for ($i = 0; $i < count($product_names); $i++) {
            $products[] = Product::create([
                'store_id' => $store_info->id,
                'category_id' => ProductCategory::where('category_name', $categories[array_rand($categories)])->select('id')->first()->value,
                'brand_id' => ProductBrand::where('brand_name', $brands[array_rand($brands)])->select('id')->first()->value,
                'unit_id' => 1,
                'type' => 'books',
                'behaviour' => $behaviours[array_rand($behaviours)]->value, // Random valid behaviour
                'name' => $product_names[$i],
                'slug' => strtolower(str_replace(' ', '-', $product_names[$i])),
                'description' => "{$product_names[$i]} is a timeless classic, offering valuable insights and stories from the past.",
                'image' => "1",
                'warranty' => json_encode([
                    ['warranty_period' => rand(1, 3), 'warranty_text' => 'Years Warranty'] // Books typically have a shorter warranty
                ]),
                'class' => 'default',
                'return_in_days' => rand(7, 30),
                'return_text' => 'Return within the specified days if unused and in original condition.',
                'allow_change_in_mind' => 'Yes',
                'cash_on_delivery' => rand(0, 1) * 100,
                'delivery_time_min' => rand(1, 2),
                'delivery_time_max' => rand(3, 7),
                'delivery_time_text' => 'Delivery may be delayed due to high demand during holidays.',
                'max_cart_qty' => rand(1, 10),
                'order_count' => rand(0, 1000),
                'views' => rand(0, 5000),
                'status' => StatusType::cases()[array_rand(StatusType::cases())]->value,
                'meta_title' => "Buy {$product_names[$i]} online",
                'meta_description' => "Order {$product_names[$i]} online and enjoy the world of literature delivered to your doorstep.",
                'meta_keywords' => "book, {$product_names[$i]}, classic, literature, $i",
                'meta_image' => "book-product$i-meta.jpg",
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
