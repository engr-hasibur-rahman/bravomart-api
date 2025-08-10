<?php

namespace App\Repositories;

use App\Models\ProductBrand;
use App\Models\Translation;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Helpers\MultilangSlug;
use App\Helpers\ComHelper;
use App\Enums\UploadDirectory;

/**
 *
 * @package namespace App\Repositories;
 */
class ProductRepository extends BaseRepository
{

    public function model()
    {
        return ProductBrand::class;
    }

    public function boot()
    {
        try {
            $this->pushCriteria(app(RequestCriteria::class));
        } catch (RepositoryException $e) {
            //
        }
    }

    public function storeProductBrand($request)
    {
        // Check if an id is present in the request
        $brandId = $request->input('id');
        if ($brandId) {
            // Update existing brand
            $brand = ProductBrand::findOrFail($brandId);
        }
        // Prepare data for brand
        $data = [
            'brand_name' => $request['brand_name'],
            'brand_slug' => MultilangSlug::makeSlug(ProductBrand::class, $request['brand_name'], 'brand_slug'),
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'display_order' => $request['display_order'],
            'brand_logo' => $request->has('brand_logo') ? ComHelper::uploadSingle(UploadDirectory::BRAND->value, $request->file('brand_logo'),$brandId!=null? $brand->brand_logo:""):"",
        ];

        if ($brandId) {
            // Update existing brand
            $brand->update($data);
        } else {
            // Create new brand
            $brand = $this->create($data);
        }

        $translations = [];
        $defaultKeys = ['brand_name', 'brand_slug', 'meta_title', 'meta_description'];

        // Handle translations
        if ($request['translations']) {
            foreach ($request['translations'] as $translation) {
                foreach ($defaultKeys as $key) {

                    // Fallback value if translation key does not exist
                    $translatedValue = $translation[$key] ?? null;

                    // Skip translation if the value is NULL
                    if ($translatedValue === null) {
                        continue; // Skip this field if it's NULL
                    }

                    // If key is brand_slug, generate slug from translated brand_name
                    if ($key === 'brand_slug') {
                        // Generate the slug from the translated brand name instead of using the default
                        $translatedValue = MultilangSlug::makeSlug(
                            Translation::class,
                            $translation['brand_name'] ?? $data['brand_name'], // Use translated brand name
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
            if ($brandId) {
                $brand->translations()->delete();
            }
            $brand->translations()->createMany($translations);
        }

        return $brand;
    }






    public function updateProductBrand($request)
    {
        // Prepare data for default brand
        $data = [
            'brand_name' => $request['brand_name'],
            'brand_slug' => MultilangSlug::makeSlug(ProductBrand::class, $request['brand_name'], 'brand_slug'),
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'display_order' => 2,
            'brand_logo' => $request['brand_logo'],
        ];

            
        $brand = $this->findOrFail($request->id)->update($data);


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
                        // Generate the slug from the translated brand name instead of using the default
                        $translatedValue = MultilangSlug::makeSlug(
                            Translation::class,
                            $translation['brand_name'] ?? $data['brand_name'], // Use translated brand name
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
