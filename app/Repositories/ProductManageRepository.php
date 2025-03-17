<?php

namespace App\Repositories;

use App\Helpers\MultilangSlug;
use App\Http\Resources\Seller\Store\Product\ProductDetailsResource;
use App\Interfaces\ProductManageInterface;
use App\Interfaces\ProductVariantInterface;
use App\Models\Store;
use App\Models\Product;
use App\Models\ProductTag;
use App\Models\ProductVariant;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ProductManageRepository implements ProductManageInterface
{
    public function __construct(protected Product $product, protected Translation $translation, protected ProductVariantInterface $variantRepo)
    {
    }

    public function translationKeys(): mixed
    {
        return $this->product->translationKeys;
    }

    public function model(): string
    {
        return Product::class;
    }

    // Fetch all products with parameters
    public function getPaginatedProduct(int|string $store_id, int|string $limit, int $page, string $language, string $type, string $search, string $sortField, string $sort, array $filters)
    {
        $product = Product::query();
        if ($store_id) {
            $product->where('store_id', $store_id);
        }
        if ($type) {
            $product->where('type', $type);
        }
        $product->leftJoin('translations as name_translations', function ($join) use ($language) {
            $join->on('products.id', '=', 'name_translations.translatable_id')
                ->where('name_translations.translatable_type', '=', Product::class)
                ->where('name_translations.language', '=', $language)
                ->where('name_translations.key', '=', 'name');
        })
            ->leftJoin('translations as description_translations', function ($join) use ($language) {
                $join->on('products.id', '=', 'description_translations.translatable_id')
                    ->where('description_translations.translatable_type', '=', Product::class)
                    ->where('description_translations.language', '=', $language)
                    ->where('description_translations.key', '=', 'description');
            })
            ->leftJoin('translations as meta_title_translations', function ($join) use ($language) {
                $join->on('products.id', '=', 'meta_title_translations.translatable_id')
                    ->where('meta_title_translations.translatable_type', '=', Product::class)
                    ->where('meta_title_translations.language', '=', $language)
                    ->where('meta_title_translations.key', '=', 'meta_title');
            })
            ->leftJoin('translations as meta_description_translations', function ($join) use ($language) {
                $join->on('products.id', '=', 'meta_description_translations.translatable_id')
                    ->where('meta_description_translations.translatable_type', '=', Product::class)
                    ->where('meta_description_translations.language', '=', $language)
                    ->where('meta_description_translations.key', '=', 'meta_description');
            })
            ->leftJoin('translations as meta_keywords_translations', function ($join) use ($language) {
                $join->on('products.id', '=', 'meta_keywords_translations.translatable_id')
                    ->where('meta_keywords_translations.translatable_type', '=', Product::class)
                    ->where('meta_keywords_translations.language', '=', $language)
                    ->where('meta_keywords_translations.key', '=', 'meta_keywords');
            })
            ->select(
                'products.*',
                DB::raw('COALESCE(name_translations.value, products.name) as name'),
                DB::raw('COALESCE(description_translations.value, products.description) as description'),
                DB::raw('COALESCE(meta_title_translations.value, products.meta_title) as meta_title'),
                DB::raw('COALESCE(meta_description_translations.value, products.meta_description) as meta_description'),
                DB::raw('COALESCE(meta_keywords_translations.value, products.meta_keywords) as meta_keywords')
            );

        // Apply search filter if search parameter exists
        if ($search) {
            $product->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', products.name, name_translations.value, products.description, description_translations.value, meta_title_translations.value, meta_description_translations.value, meta_keywords_translations.value)"), 'like', "%{$search}%");
            });
        }

        // Apply sorting and pagination
        return $product->with('variants')
            ->orderBy($sortField ?? 'id', $sort ?? 'asc')
            ->paginate($limit);
    }


    // Store data
    public function store(array $data)
    {
        try {
            $data = Arr::except($data, ['translations']);
            $product = Product::create($data);

            // If variants exist 
            if (!empty($data['variants']) && is_array($data['variants'])) {
                $variants = array_map(function ($variant) use ($product) {
                    // Generate the variant slug
//                    $variant_slug = generateVariantSlug($variant['variant']);
                    $variant['attributes'] = json_encode($variant['attributes']);
                    $variant['variant_slug'] = $variant['variant']; // Assign the generated slug
                    // Generate a SKU for the variant
                    $sku = generateUniqueSku(); // This function generates a unique SKU
                    $variant['sku'] = $sku; // Assign the generated SKU
                    $variant['product_id'] = $product->id;
                    return $variant;
                }, $data['variants']);
                // insert all variants at once
                //ProductVariant::insert($variants);
                foreach ($variants as $variant) {
                    ProductVariant::create($variant);
                }
            }

            // Product Tag add
            if (!empty($data['tag_ids']) && is_array($data['tag_ids'])) {
                $productTags = [];
                foreach ($data['tag_ids'] as $tagId) {
                    $productTags[] = [
                        'product_id' => $product->id,
                        'tag_id' => $tagId,
                    ];
                }
                ProductTag::insert($productTags);
            }
            return $product->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeBulk(array $bulkData)
    {
        try {
            // store the IDs of inserted products for bulk entry
            $productIds = [];

            foreach ($bulkData as $data) {
                // Remove translations if it exists
                $data = Arr::except($data, ['translations']);

                // Create the product
                $product = Product::create($data);
                $productIds[] = $product->id; // Collect the product ID

                // product variants store if variants are not empty
                if (!empty($data['variants']) && is_array($data['variants'])) {
                    $variants = array_map(function ($variant) use ($product) {
                        $variant_slug = MultilangSlug::makeSlug(ProductVariant::class, $variant['variant_slug'], 'variant_slug');
                        $variant['variant_slug'] = $variant_slug;
                        $variant['sku'] = generateUniqueSku();
                        $variant['product_id'] = $product->id;
                        return $variant;
                    }, $data['variants']);
                    ProductVariant::insert($variants);
                }
            }
            return $productIds;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data)
    {
        try {
            // Exclude translations from the update data
            $data = Arr::except($data, ['translations']);

            // Retrieve the product by ID
            $product = Product::findorfail($data['id']);
            // Update the product details
            $product->update($data);

            // Update or create variants
            if (!empty($data['variants']) && is_array($data['variants'])) {
                $variantIds = []; // Track updated & newly created variant IDs

                foreach ($data['variants'] as $variant) {
                    // Convert attributes to JSON if provided
                    $variant['attributes'] = !empty($variant['attributes']) ? json_encode($variant['attributes']) : null;
                    $variant['variant_slug'] = $variant['variant']; // Assign the generated slug
                    $variant['product_id'] = $product->id;

                    if (!empty($variant['id'])) {
                        // Check if the variant exists
                        $existingVariant = ProductVariant::where('id', $variant['id'])->where('product_id', $product->id)->first();
                        if ($existingVariant) {
                            // Generate SKU if null
                            if (empty($variant['sku'])) {
                                $variant['sku'] = generateUniqueSku();
                            }
                            $existingVariant->update($variant);
                            $variantIds[] = $existingVariant->id;
                        }
                    } else {
                        // Generate SKU if null
                        if (empty($variant['sku'])) {
                            $variant['sku'] = generateUniqueSku();
                        }
                        $newVariant = ProductVariant::create($variant);
                        $variantIds[] = $newVariant->id;
                    }
                }

                // Delete variants not present in the request
                ProductVariant::where('product_id', $product->id)
                    ->whereNotIn('id', $variantIds)
                    ->forceDelete();
            }

            // Update product tags
            if (!empty($data['tag_ids']) && is_array($data['tag_ids'])) {
                // First, delete existing tags to avoid duplicates
                $product->tags()->delete();

                // Insert the new tags
                $productTags = [];
                foreach ($data['tag_ids'] as $tagId) {
                    $productTags[] = [
                        'product_id' => $product->id,
                        'tag_id' => $tagId,
                    ];
                }
                ProductTag::insert($productTags);
            }

            return $product->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // Delete data
    public function delete(int|string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // Fetch product data of specific id
    public function getProductBySlug(string $slug)
    {
        try {
            $product = Product::with([
                'related_translations',
                'variants',
                'store.seller',
                'category',
                'brand',
                'unit',
            ])
                ->where('slug', $slug)
                ->first();
            if ($product) {
                return response()->json(new ProductDetailsResource($product));
            } else {
                return response()->json([
                    "massage" => "Data was not found"
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // Store translation
    public function storeTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
    {
        $translations = [];
        if ($request['translations']) {
            foreach ($request['translations'] as $translation) {
                foreach ($colNames as $key) {
                    // Fallback value if translation key does not exist
                    $translatedValue = $translation[$key] ?? null;
                    // Skip translation if the value is NULL
                    if ($translatedValue === null) {
                        continue; // Skip this field if it's NULL
                    }
                    // Collect translation data
                    $translations[] = [
                        'translatable_type' => $refPath,
                        'translatable_id' => $refid,
                        'language' => $translation['language_code'],
                        'key' => $key,
                        'value' => $translatedValue,
                    ];
                }
            }
        }
        if (count($translations)) {
            $this->translation->insert($translations);
        }
        return true;
    }

    public function updateTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
    {
        $translations = [];
        if ($request['translations']) {
            foreach ($request['translations'] as $translation) {
                foreach ($colNames as $key) {

                    // Fallback value if translation key does not exist
                    $translatedValue = $translation[$key] ?? null;

                    // Skip translation if the value is NULL
                    if ($translatedValue === null) {
                        continue; // Skip this field if it's NULL
                    }

                    $trans = $this->translation->where('translatable_type', $refPath)->where('translatable_id', $refid)
                        ->where('language', $translation['language_code'])->where('key', $key)->first();
                    if ($trans != null) {
                        $trans->value = $translatedValue;
                        $trans->save();
                    } else {
                        $translations[] = [
                            'translatable_type' => $refPath,
                            'translatable_id' => $refid,
                            'language' => $translation['language_code'],
                            'key' => $key,
                            'value' => $translatedValue,
                        ];
                    }
                }
            }
        }
        if (count($translations)) {
            $this->translation->insert($translations);
        }
        return true;
    }

    // Fetch deleted records(true = only trashed records, false = all records with trashed)
    public function records(bool $onlyDeleted = false)
    {
        try {
            switch ($onlyDeleted) {
                case true:
                    $records = Product::onlyTrashed()->get();
                    break;

                default:
                    $records = Product::withTrashed()->get();
                    break;
            }
            return $records;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function changeStatus(array $data): mixed
    {
        try {
            $product = Product::findOrFail($data['id']);
            $product->status = $data['status'];
            $product->save();
            return $product;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function approvePendingProducts(array $productIds)
    {
        try {
            $products = Product::whereIn('id', $productIds)
                ->where('deleted_at', null)
                ->update([
                    'status' => 'approved'
                ]);
            return true;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 404
            ]);
        }
    }

    public function getPendingProducts()
    {
        try {
            $products = Product::where('deleted_at', '=', null)
                ->where('status', 'pending')
                ->with(['store.related_translations', 'related_translations'])
                ->latest()
                ->paginate(10);
            return $products;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
