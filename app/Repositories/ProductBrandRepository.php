<?php

namespace App\Repositories;

use App\Models\ProductBrand;
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


    protected $dataArray = [
        'brand_name',
        'brand_slug',
        'brand_logo',
        'meta_title',
        'meta_description',
        'display_order',
        'created_by',
        'updated_by',
    ];


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
        $data = $request->only($this->dataArray);
        
        $data['brand_name'] = $request['brand_name_default'];
        $data['brand_slug'] = MultilangSlug::makeSlug(ProductBrand::class, $data['brand_name'], 'brand_slug');

        if (isset($request['brand_logo']) && is_array($request['brand_logo'])) {
            $data['brand_logo'] = json_encode($request['brand_logo']);
        }
        logger($data['brand_logo']);
        $brand = $this->create($data);

        if (isset($request['translations']) && count($request['translations'])) {
            $brand->translations()->createMany($request['translations']);
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
