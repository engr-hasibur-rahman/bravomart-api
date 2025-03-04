<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Resources\Com\Product\ProductCategoryResource;
use App\Http\Resources\ProductCategoryByIdResource;
use App\Models\ProductCategory;
use App\Repositories\ProductCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{

    public function __construct(
        public ProductCategoryRepository $repository,
    )
    {
    }

    public function index(Request $request)
    {

        $per_page = $request->per_page ?? 10;
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
        if ($request->pagination == "false") {
            $categories = $categories->whereNull('parent_id')->orderBy($request->sortField ?? 'id', $request->sort ?? 'asc')
                ->get();

        } else {
            $categories = $categories->orderBy($request->sortField ?? 'id', $request->sort ?? 'asc')
                ->paginate($per_page);
        }
        // Return a collection of ProductBrandResource (including the image)
        return ProductCategoryResource::collection($categories);
        //return $categories;
    }


    public function show(Request $request)
    {
        $category = $this->repository->with(['related_translations'])->findOrFail($request->id);
        if ($category) {
            return response()->json(new ProductCategoryByIdResource($category));
        } else {
            return response()->json(['message' => __('messages.data_not_found')], 404);
        }
    }

    public function store(StoreProductCategoryRequest $request)
    {
        try {
            $this->repository->storeProductCategory($request);
            return response()->json([
                'message' => __('messages.save_success', ['name' => 'Product Category']),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function productCategoryStatus(Request $request)
    {
        $productCategory = ProductCategory::find($request->id);
        if ($productCategory) {
            $productCategory->status = !$productCategory->status;
            $productCategory->save();
            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Product category status']),
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.data_not_found')
            ], 404);
        }

    }
}
