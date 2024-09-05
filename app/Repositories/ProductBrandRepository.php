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
        if (empty($request['slug'])) {
            $data['slug'] = MultilangSlug::makeSlug(ProductBrand::class, $request['slug']);
        }
        $brand = $this->create($request->only($this->dataArray));
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
