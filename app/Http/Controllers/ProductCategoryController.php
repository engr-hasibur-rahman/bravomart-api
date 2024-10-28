<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Resources\ProductCategoryByIdResource;
use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use App\Repositories\FileUploadRepository;
use App\Repositories\ProductCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{

    public function __construct(
        public ProductCategoryRepository $repository,
        public FileUploadRepository $fileUploadRepository
    ) {}

    public function index(Request $request)
    {
        
        $limit = $request->limit ?? 10;
        $language = $request->language ?? DEFAULT_LANGUAGE;
        $search = $request->search;

        $categories = ProductCategory::leftJoin('translations', function ($join) use ($language) {
            $join->on('product_category.id', '=', 'translations.translatable_id')
                ->where('translations.translatable_type', '=', ProductCategory::class)
                ->where('translations.language', '=', $language)
                ->where('translations.key', '=', 'category_name');
        })
            ->select(
                'product_category.*',
                DB::raw('COALESCE(translations.value, product_category.category_name) as category_name')
            );

        // Apply search filter if search parameter exists
        if ($search) {
            $categories->where(function ($query) use ($search) {
                $query->where('translations.value', 'like', "%{$search}%")
                    ->orWhere('product_category.category_name', 'like', "%{$search}%");
            });
        }

        // Apply sorting and pagination
        if($request->pagintion == "false"){
            $categories = $categories->orderBy($request->sortField ?? 'id', $request->sort ?? 'asc')
            ->get();
            
        }else {
            $categories = $categories->orderBy($request->sortField ?? 'id', $request->sort ?? 'asc')
            ->paginate($limit);
        }
        // Return a collection of ProductBrandResource (including the image)
        return ProductCategoryResource::collection($categories);
    }


    public function show($id)
    {
        $category = $this->repository->with(['translations'])->findOrFail($id);
        if ($category) {
            return new ProductCategoryByIdResource($category);
        }

        return response()->json(['error' => 'Product Brand not found'], 404);
    }

    public function store(StoreProductCategoryRequest $request, FileUploadRepository $fileUploadRepository)
    {
        try {
            $this->repository->storeProductCategory($request, $fileUploadRepository);

            return response()->json([
                'success' => 'Success'
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException('Could not create the product Category.');
        }
    }

    public function productCategoryStatus(Request $request)
    {
        $productCategory = ProductCategory::findOrFail($request->id);
        $productCategory->status = !$productCategory->status;
        $productCategory->save();
        return response()->json([
            'success' => true,
            'message' => 'Product brand status updated successfully',
            'status' => $productCategory->status
        ]);
    }
}
