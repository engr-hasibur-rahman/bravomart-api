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
        $attributes_sets = [
            'grocery' => [
                'weight' => ['50g','100g', '150g','250g', '500g', '1kg', '1.5kg', '2kg','3kg', '4kg', '5kg'],
                'type' => ['Fresh', 'Frozen', 'Dried','Smoked', 'Marinated','Liquid', 'Powder', 'Spray', 'Wipes'],
                'flavor' => ['Spicy', 'Sweet', 'Salty', 'Cheesy','Honey', 'Chocolate', 'Vanilla', 'Fruits'],
                'dietary_preference' => ['Gluten-Free', 'Low-Calorie', 'Vegan'],
                'packaging' => ['Single Pack', 'Multi-Pack','Loose', 'Packed', 'Resealable Bag','Bottle', 'Carton', 'Plastic Tub','Box', 'Bag'],
                'packaging_size' => ['Small', 'Medium', 'Large','500ml', '1L', '5L'],
                'expiry_date' => [ '2025-12-31', '2026-06-30', '2027-01-01', '2027-12-31', '2028-06-30', '2028-12-31', '2029-01-15', '2029-06-30', '2029-12-31', '2030-06-30','2030-12-31',],
            ],
            'bakery' => [
                'flavor' => ['Vanilla', 'Chocolate', 'Strawberry'],
                'weight' => ['500g', '1kg', '2kg'],
                'packaging_type' => ['Box', 'Bag', 'Plastic'],
                'expiry_date' => [ '2025-12-31', '2026-06-30', '2027-01-01', '2027-12-31', '2028-06-30', '2028-12-31', '2029-01-15', '2029-06-30', '2029-12-31', '2030-06-30','2030-12-31',],
            ],
            'medicine' => [
                'dosage' => ['50mg', '100mg', '200mg'],
                'manufacturer' => ['Company A', 'Company B'],
                'type' => ['Tablet', 'Capsule', 'Syrup', 'Injection'],
                'expiry_date' => [ '2025-12-31', '2026-06-30', '2027-01-01', '2027-12-31', '2028-06-30', '2028-12-31', '2029-01-15', '2029-06-30', '2029-12-31', '2030-06-30','2030-12-31',],
            ],
            'makeup' => [
                'shade' => ['Light', 'Medium', 'Dark', 'Fair', 'Tan', 'Deep'],
                'volume' => ['15ml', '30ml', '50ml', '100ml'],
                'skin_type' => ['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'],
                'product_type' => ['Foundation', 'Concealer', 'Lipstick', 'Mascara', 'Eyeliner', 'Blush', 'Highlighter'],
                'packaging' => ['Tube', 'Bottle', 'Compact', 'Palette'],
                'expiry_date' => [ '2025-12-31', '2026-06-30', '2027-01-01', '2027-12-31', '2028-06-30', '2028-12-31', '2029-01-15', '2029-06-30', '2029-12-31', '2030-06-30','2030-12-31',],
            ],
            'clothing' => [
                'color' => [
                    'Red', 'Blue', 'Green', 'Black', 'White', 'Yellow', 'Pink', 'Purple', 'Orange', 'Gray', 'Brown', 'Beige', 'Navy', 'Turquoise', 'Indigo'
                ],
                'size' => [
                    'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'XXS', 'One Size'
                ],
                'material' => [
                    'Cotton', 'Leather', 'Polyester', 'Linen', 'Silk', 'Wool', 'Nylon', 'Denim', 'Spandex', 'Rayon', 'Velvet', 'Fleece', 'Chiffon', 'Acrylic'
                ],
            ],
            'bags' => [
                'material' => [
                    'Leather', 'Canvas', 'Nylon', 'Suede', 'Polyester', 'Jute', 'Vegan Leather', 'PVC', 'Wool', 'Satin', 'Cordura'
                ],
                'size' => [
                    'Small', 'Medium', 'Large', 'Extra Large', 'Mini', 'One Size'
                ],
                'color' => [
                    'Red', 'Blue', 'Black', 'Brown', 'White', 'Pink', 'Purple', 'Beige', 'Green', 'Yellow', 'Orange', 'Gray', 'Navy', 'Tan'
                ],
                'style' => [
                    'Tote', 'Backpack', 'Crossbody', 'Clutch', 'Satchel', 'Messenger', 'Duffel', 'Shoulder', 'Hobo', 'Briefcase'
                ],
                'closure_type' => [
                    'Zipper', 'Button', 'Magnetic', 'Drawstring', 'Snap', 'Buckle'
                ],
            ],
            'furniture' => [
                'material' => [
                    'Wood', 'Metal', 'Plastic', 'Glass', 'Leather', 'Fabric', 'Marble', 'Stone', 'Concrete', 'Rattan', 'Bamboo', 'Mirrored', 'Polyurethane', 'Velvet'
                ],
                'dimensions' => [
                    '100x50x30', '150x75x50', '200x100x75', '120x60x40', '180x90x60', '250x150x100', '90x45x30', '60x30x20'
                ],
                'weight_capacity' => [
                    '50kg', '100kg', '200kg', '300kg', '500kg', '1000kg'
                ],
                'style' => [
                    'Modern', 'Contemporary', 'Traditional', 'Vintage', 'Rustic', 'Industrial', 'Scandinavian', 'Minimalist', 'Bohemian'
                ],
                'color' => [
                    'Red', 'Blue', 'Green', 'Black', 'White', 'Gray', 'Brown', 'Beige', 'Tan', 'Navy', 'Olive', 'Gold', 'Silver', 'Cream', 'Wooden Finish'
                ],
            ],
            'books' => [
                'author' => ['Author A', 'Author B', 'Author C'],
                'genre' => ['Fiction', 'Non-fiction', 'Sci-fi'],
                'language' => ['English', 'Spanish', 'French']
            ],
            'gadgets' => [
                'model' => ['Model X', 'Model Y', 'Model Z', 'ProMax', 'UltraX', 'ElitePlus', 'SmartOne', 'Vision'],
                'specifications' => [
                    'Spec 1', 'Spec 2', 'Spec 3', '4GB RAM', '8GB RAM', '16GB RAM', '64GB Storage', '128GB Storage', '256GB Storage', 'Full HD Display', '4K Display', 'Bluetooth 5.0', 'Wi-Fi 6', '5000mAh Battery', 'Fast Charging', 'Water Resistant', 'GPS Enabled', 'NFC Support', 'Wireless Charging', 'Fingerprint Scanner', 'Face Recognition'
                ],
                'color' => [
                    'Black', 'White', 'Silver', 'Gold', 'Blue', 'Red', 'Green', 'Pink', 'Purple', 'Gray', 'Rose Gold', 'Copper'
                ],
                'size' => [
                    'Small', 'Medium', 'Large', 'Compact', 'Slim', 'Standard'
                ],
            ],
            'animals-pet' => [
                'breed' => [
                    'Breed A', 'Breed B', 'Breed C', 'Labrador', 'Golden Retriever', 'Siamese', 'Persian', 'Maine Coon', 'Bulldog', 'Beagle', 'Shih Tzu', 'Tabby', 'Rottweiler', 'Chihuahua', 'Husky', 'Cocker Spaniel'
                ],
                'age' => [
                    'Puppy', 'Kitten', 'Adult', 'Senior', 'Newborn'
                ],
                'size' => [
                    'Small', 'Medium', 'Large', 'Extra Large', 'Tiny', 'Miniature'
                ],
                'weight' => [
                    'Under 5kg', '5kg - 10kg', '10kg - 20kg', '20kg - 40kg', '40kg and above'
                ],
                'color' => [
                    'Black', 'White', 'Brown', 'Golden', 'Gray', 'Spotted', 'Tan', 'Multi-Color', 'Cream', 'Red', 'Blue', 'Striped', 'Spotted'
                ],
                'special_needs' => [
                    'No', 'Yes - Allergy-Friendly', 'Yes - Medical Assistance', 'Yes - Dietary Restrictions', 'Yes - Wheelchair'
                ],
            ],
            'fish' => [
                'weight' => [
                    'Under 1kg', '1kg - 2kg', '2kg - 5kg', '5kg - 10kg', 'Above 10kg'
                ],
                'fish_size' => [
                    'Small', 'Medium', 'Large', 'Extra Large', 'Miniature', 'Jumbo'
                ],
                'fish_location' => [
                    'Atlantic', 'Pacific', 'Indian Ocean', 'Arctic Ocean', 'Mediterranean Sea', 'Caribbean Sea', 'South China Sea', 'Gulf of Mexico', 'Great Barrier Reef'
                ],
                'fish_color' => [
                    'Silver', 'Red', 'Pink', 'Brown', 'Golden', 'Green', 'Blue', 'White', 'Black', 'Spotted'
                ],
                'packaging' => [
                    'Whole Fish', 'Fillet', 'Steak', 'Sliced', 'Minced', 'Canned', 'Frozen', 'Smoked'
                ],
                'storage_method' => [
                    'Refrigerate', 'Freeze', 'Cool Storage'
                ]
            ],
        ];

        return $attributes[$storeType] ?? ['Default Attribute'];
    }

}
