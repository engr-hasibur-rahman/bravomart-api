<?php

namespace App\Repositories;

use App\Models\ProductBrand;
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

    public function storeProductBrand($request)
    {
        $data = [];

        // Store default brand data
        $data['brand_name'] = $request['brand_name_default'];
        $data['brand_slug'] = MultilangSlug::makeSlug(ProductBrand::class, $data['brand_name'], 'brand_slug');
        $data['meta_title'] = $request['meta_title_default'];
        $data['meta_description'] = $request['meta_description_default'];
        $data['display_order'] = 2;


        if ($request->hasFile('brand_logo')) {
            $file = $request->file('brand_logo');
            $filePath = $file->store('brand_logos', 'public');
            $fullUrl = Storage::url($filePath);
            $data['brand_logo'] = $fullUrl;
        }
        $brand = $this->create($data);

        $languages = [
            'en' => 'english',
            'ar' => 'arabic',
        ];

        // Define the keys that need translations
        $translationKeys = ['brand_name', 'brand_slug', 'meta_title', 'meta_description'];

        $translations = [];

        foreach ($languages as $langCode => $langSuffix) {
            foreach ($translationKeys as $key) {
                $requestKey = "{$key}_{$langSuffix}";

                if ($key == 'brand_slug') {
                    // Generate slug based on the brand name for the specific language
                    $brandNameKey = "brand_name_{$langSuffix}";
                    $value = MultilangSlug::makeSlug(ProductBrand::class, $request[$brandNameKey], 'brand_slug');
                } else {
                    $value = $request[$requestKey] ?? null;
                }

                if (!empty($value)) {
                    $translations[] = [
                        'language' => $langCode,
                        'key' => $key,
                        'value' => $value,
                    ];
                }
            }
        }

        // Insert translations into the translations table
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
