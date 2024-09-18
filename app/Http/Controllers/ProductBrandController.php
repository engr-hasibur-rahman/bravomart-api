<?php

namespace App\Http\Controllers;

use App\Exports\ExportProductBrand;
use App\Http\Requests\StoreProductBrandRequest;
use App\Http\Requests\UpdateProductBrandRequest;
use App\Http\Resources\ProductBrandByIdResource;
use App\Http\Resources\ProductBrandResource;
use App\Models\ProductBrand;
use App\Repositories\FileUploadRepository;
use App\Repositories\ProductBrandRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\QueryBuilder;

class ProductBrandController extends Controller
{

    public function __construct(
        public ProductBrandRepository $repository,
        public FileUploadRepository $fileUploadRepository
    ) {}

    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $language = $request->language ?? DEFAULT_LANGUAGE;
        $search = $request->search;

        $brands = ProductBrand::leftJoin('translations', function ($join) use ($language) {
            $join->on('product_brand.id', '=', 'translations.translatable_id')
                ->where('translations.translatable_type', '=', ProductBrand::class)
                ->where('translations.language', '=', $language)
                ->where('translations.key', '=', 'brand_name');
        })
            ->select(
                'product_brand.*',
                DB::raw('COALESCE(translations.value, product_brand.brand_name) as brand_name')
            );

        // Apply search filter if search parameter exists
        if ($search) {
            $brands->where(function ($query) use ($search) {
                $query->where('translations.value', 'like', "%{$search}%")
                    ->orWhere('product_brand.brand_name', 'like', "%{$search}%");
            });
        }

        // Apply sorting and pagination
        $brands = $brands->orderBy($request->sortField ?? 'id', $request->sort ?? 'asc')
            ->paginate($limit);

        // Return a collection of ProductBrandResource (including the image)
        return ProductBrandResource::collection($brands);
    }


    public function show($id)
    {
        $brand = $this->repository->with(['translations'])->findOrFail($id);
        if ($brand) {
            return new ProductBrandByIdResource($brand);
        }

        return response()->json(['error' => 'Product Brand not found'], 404);
    }

    public function store(StoreProductBrandRequest $request, FileUploadRepository $fileUploadRepository)
    {
        try {
            $brand = $this->repository->storeProductBrand($request, $fileUploadRepository);

            return response()->json([
                'success' => 'Success'
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException('Could not create the product brand.');
        }
    }

    public function productBrandStatus($id)
    {
        $productBrand = ProductBrand::findOrFail($id);
        $productBrand->status = !$productBrand->status;
        $productBrand->save();
        return response()->json([
            'success' => true,
            'message' => 'Product brand status updated successfully',
            'status' => $productBrand->status
        ]);
    }

    public function exportProductBrand()
    {
        return Excel::download(new ExportProductBrand, 'product_brand.xlsx');
    }
}
