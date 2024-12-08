<?php

namespace App\Repositories;

use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\Translation;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Helpers\MultilangSlug;

/**
 *
 * @package namespace App\Repositories;
 */
class ProductCategoryRepository extends BaseRepository
{

    public function model()
    {
        return ProductCategory::class;
    }

    public function boot()
    {
        try {
            $this->pushCriteria(app(RequestCriteria::class));
        } catch (RepositoryException $e) {
            //
        }
    }

    public function storeProductCategory($request, $fileUploadRepository)
    {
        // Check if an id is present in the request
        $categoryId = $request->input('id');

        // Prepare data for category
        $data = [
            'category_name' => $request['category_name'],
            'category_slug' => MultilangSlug::makeSlug(ProductCategory::class, $request['category_name'], 'category_slug'),
            'category_name_paths' => $request['category_name_paths'],
            'parent_path' => $request['parent_path'],
            'parent_id' => $request['parent_id'],
            'is_featured' => filter_var($request['is_featured'], FILTER_VALIDATE_BOOLEAN),
            'admin_commission_rate' => false,
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'display_order' => $request['display_order'],
        ];

        if ($categoryId) {
            // Update existing category
            $category = ProductCategory::findOrFail($categoryId);
            $category->update($data);
        } else {
            // Create new category
            $category = $this->create($data);
        }


        // Handle file upload if available
        if ($request->hasFile('category_banner')) {
            $file = $request->file('category_banner');
            $fileUploadRepository->attachment($file, 'category_banner', $categoryId, $category, ['dir_name'=>'category']);
        }
        // Handle file upload if available
        if ($request->hasFile('category_thumb')) {
            $file = $request->file('category_thumb');
            $fileUploadRepository->attachment($file, 'category_thumb', $categoryId, $category, ['dir_name'=>'category']);
        }

        $translations = [];
        $defaultKeys = ['category_name', 'category_slug', 'meta_title', 'meta_description'];
        // Handle translations
        if ($request['translations']) {
            foreach ($request['translations'] as $translation) {
                foreach ($defaultKeys as $key) {

                    // Fallback value if translation key does not exist
                    $translatedValue = $translation[$key] ?? null;

                    // Skip translation if the value is NULL GU
                    if ($translatedValue === null) {
                        continue; // Skip this field if it's NULL
                    }

                    // If key is brand_slug, generate slug from translated category_name
                    if ($key === 'category_slug') {
                        // Generate the slug from the translated category name instead of using the default
                        $translatedValue = MultilangSlug::makeSlug(
                            Translation::class,
                            $translation['category_name'] ?? $data['category_name'], // Use translated category name
                            'value'
                        );
                    }

                    // Collect translation data
                    $translations[] = [
                        'language' => $translation['language_code'],
                        'key' => $key,
                        'value' => $translatedValue,
                    ];
                }
            }
        }

        // Save translations if available
        if (!empty($translations)) {
            // If updating, delete existing translations first
            if ($categoryId) {
                $category->translations()->delete();
            }
            $category->translations()->createMany($translations);
        }

        return $category;
    }


    public function updateProductBrand($request, $brand, $fileUploadRepository)
    {
        // Prepare data for default category
        $data = [
            'brand_name' => $request['brand_name'],
            'brand_slug' => MultilangSlug::makeSlug(ProductCategory::class, $request['brand_name'], 'brand_slug'),
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'display_order' => 2,
        ];

        $brand = $this->findOrFail($request->id)->update($data);

        if ($request->hasFile('brand_logo')) {
            $file = $request->file('brand_logo'); // Only call this once

            $fileData = $fileUploadRepository->uploadFile($file);
            $brand->media()->create($fileData);
        }

        $translations = [];
        $defaultKeys = ['brand_name', 'brand_slug', 'meta_title', 'meta_description'];

        // Handle translations
        if ($request['translations']) {
            foreach ($request['translations'] as $translation) {
                foreach ($defaultKeys as $key) {

                    // Fallback value if translation key does not exist
                    $translatedValue = $translation[$key] ?? null;

                    // If key is brand_slug, generate slug from translated brand_name
                    if ($key === 'brand_slug') {
                        // Generate the slug from the translated category name instead of using the default
                        $translatedValue = MultilangSlug::makeSlug(
                            Translation::class,
                            $translation['brand_name'] ?? $data['brand_name'], // Use translated category name
                            'value'
                        );
                    }

                    // Collect translation data
                    $translations[] = [
                        'language' => $translation['language_code'],
                        'key' => $key,
                        'value' => $translatedValue,
                    ];
                }
            }
        }

        // Save translations if available
        if (!empty($translations)) {
            $brand->translations()->createMany($translations);
        }

        return $brand;
    }
}
