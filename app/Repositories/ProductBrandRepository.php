<?php

namespace App\Repositories;

use App\Models\ProductBrand;
use App\Models\Translation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;
use Shamim\DewanMultilangSlug\Facades\MultilangSlug;

/**
 * Interface ProductBrandRepositoryRepository.
 *
 * @package namespace App\Repositories;
 */
class ProductBrandRepository extends BaseRepository
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

    public function storeProductBrand($request, $fileUploadService)
    {
        // Prepare data for default brand
        $data = [
            'brand_name' => $request['brand_name'],
            'brand_slug' => MultilangSlug::makeSlug(ProductBrand::class, $request['brand_name'], 'brand_slug'),
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'display_order' => 2,
        ];

        // Handle file upload if brand logo exists
        if ($request->hasFile('brand_logo')) {
            $file = $request->file('brand_logo');
            $filePath = $fileUploadService->uploadFile($file);

            $data['brand_logo'] = $filePath;
        }

        // Create the brand with default data
        $brand = $this->create($data);
        $translations = [];
        $defaultKeys = ['brand_name', 'brand_slug', 'meta_title', 'meta_description'];

        // Handle translations
        if ($request['translations']) {
            foreach ($request['translations'] as $translation) {
                foreach ($defaultKeys as $key) {

                    // Fallback value if translation key does not exist
                    $translatedValue = $translation[$key] ?? $data[$key] ?? null;

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


    public function updateProductBrand($request, $brand)
    {
        // $request['slug'] = $this->makeSlug($request);
        $data = $request->only($this->dataArray);
        if (isset($request['translations']) && count($request['translations'])) {
            $brand->translations()->createMany($request['translations']);
        }
        $brand->update($data);
        return $this->findOrFail($brand->id);
    }
}
