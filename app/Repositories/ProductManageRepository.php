<?php

namespace App\Repositories;

use App\Interfaces\ProductManageInterface;
use App\Models\Product;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ProductManageRepository implements ProductManageInterface
{
    public function __construct(protected Product $product, protected Translation $translation) {}
    public function translationKeys(): mixed
    {
        return $this->product->translationKeys;
    }
    public function model(): string
    {
        return Product::class;
    }
    public function getPaginatedProduct(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        $product = Product::leftJoin('translations as name_translations', function ($join) use ($language) {
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
            ->select(
                'products.*',
                DB::raw('COALESCE(name_translations.value, products.name) as name'),
                DB::raw('COALESCE(description_translations.value, products.description) as description')
            );
        // Apply search filter if search parameter exists
        if ($search) {
            $product->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', products.name, name_translations.value, products.description, description_translations.value)"), 'like', "%{$search}%");
            });
        }
        // Apply sorting and pagination
        // Return the result
        return $product
            ->orderBy($request->sortField ?? 'id', $request->sort ?? 'asc')
            ->paginate($limit);
    }
    public function store(array $data)
    {
        try {
            $data = Arr::except($data, ['translations']);
            $product = Product::create($data);
            return $product->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function update(array $data)
    {
        try {
            $product = Product::findOrFail($data['id']);
            if ($product) {
                $data = Arr::except($data, ['translations']);
                $product->update($data);
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
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
    public function getProductById(int|string $id)
    {
        try {
            $product = Product::find($id);
            $translations = $product->translations()->get()->groupBy('language');
            // Initialize an array to hold the transformed data
            $transformedData = [];
            foreach ($translations as $language => $items) {
                $languageInfo = ['language' => $language];
                /* iterate all Column to Assign Language Value */
                foreach ($this->product->translationKeys as $columnName) {
                    $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
                }
                $transformedData[] = $languageInfo;
            }
            if ($product) {
                return response()->json([
                    "data" => $product->toArray(),
                    'translations' => $transformedData,
                    "massage" => "Data was found"
                ], 201);
            } else {
                return response()->json([
                    "massage" => "Data was not found"
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function storeTranslation(Request $request, int|string $refid, string $refPath, array  $colNames): bool
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
}
