<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductBrandRequest;
use App\Http\Requests\UpdateProductBrandRequest;
use App\Http\Resources\ProductBrandResource;
use App\Models\ProductBrand;
use App\Repositories\ProductBrandRepository;
use App\Services\FileUploadService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProductBrandController extends Controller
{

    public function __construct(public ProductBrandRepository $repository) {}

    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;

        $brandsQuery = QueryBuilder::for(ProductBrand::class)
            ->with('translations') 
            ->allowedFilters([])
            ->allowedSorts([])
            ->defaultSort('-id');

        $brands = $brandsQuery->paginate($limit);

        return ProductBrandResource::collection($brands);
    }
    public function show($id)
    {
        $brand = $this->repository->findOrFail($id);
        if ($brand) {
            return new ProductBrandResource($brand);
        }

        return response()->json(['error' => 'Product Brand not found'], 404);
    }

    public function store(StoreProductBrandRequest $request, FileUploadService $fileUploadService)
    {
        try {
            $brand = $this->repository->storeProductBrand($request, $fileUploadService);
            return new ProductBrandResource($brand);
        } catch (\Exception $e) {
            throw new \RuntimeException('Could not create the product brand.');
        }
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
