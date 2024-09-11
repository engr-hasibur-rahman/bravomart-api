<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductBrandRequest;
use App\Http\Requests\UpdateProductBrandRequest;
use App\Http\Resources\ProductBrandResource;
use App\Models\ProductBrand;
use App\Repositories\FileUploadRepository;
use App\Repositories\ProductBrandRepository;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProductBrandController extends Controller
{

    public function __construct(
        public ProductBrandRepository $repository, 
        public FileUploadRepository $fileUploadRepository) {}

    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;

        $brandsQuery = QueryBuilder::for(ProductBrand::class)
            ->with('translations') 
            ->allowedFilters([])
            ->allowedSorts(['id', 'brand_name'])
            ->defaultSort('-id');

        $brands = $brandsQuery->paginate($limit);

        return ProductBrandResource::collection($brands);
    }
    public function show($id)
    {
        $brand = $this->repository->with('translations')->findOrFail($id);
        return $brand;
        if ($brand) {
            return $brand;
        }

        return response()->json(['error' => 'Product Brand not found'], 404);
    }

    public function store(StoreProductBrandRequest $request, FileUploadRepository $fileUploadRepository)
    {
        // try {
            $brand = $this->repository->storeProductBrand($request, $fileUploadRepository);
            return new ProductBrandResource($brand);
        // } catch (\Exception $e) {
        //     throw new \RuntimeException('Could not create the product brand.');
        // }
    }

    public function update(UpdateProductBrandRequest $request, $id)
    {
        $request->id = $id;

        $brand = $this->repository->findOrFail($request->id);
        return new ProductBrandResource($this->repository->updateProductBrand($request, $brand));
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return response()->json(['message' => 'Product Brand deleted successfully']);
    }
}
