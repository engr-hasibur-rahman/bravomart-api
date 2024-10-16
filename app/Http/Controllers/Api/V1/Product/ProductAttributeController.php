<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAttributeRequest;
use App\Http\Resources\ProductAttributeResource;
use App\Repositories\ProductAttributeRepository;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

class ProductAttributeController extends Controller
{
    public function __construct(
        public ProductAttributeRepository $repository
    ) {}


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $language = $request->language ?? DEFAULT_LANGUAGE;
        $search = $request->search;

        $limit = $request->limit ?? 10;
        //$attributes = QueryBuilder::for(ProductAttribute::class)->paginate($limit);

        $attributes = ProductAttribute::leftJoin('translations', function ($join) use ($language) {
            $join->on('product_attributes.id', '=', 'translations.translatable_id')
                ->where('translations.translatable_type', '=', ProductAttribute::class)
                ->where('translations.language', '=', $language)
                ->where('translations.key', '=', 'attribute_name');
        })
            ->select('product_attributes.*', 
            DB::raw('COALESCE(translations.value, product_attributes.attribute_name) as attribute_name'));

        // Apply search filter if search parameter exists
        if ($search) {
            $attributes->where(function ($query) use ($search) {
                $query->where('translations.value', 'like', "%{$search}%")
                    ->orWhere('product_attributes.attribute_name', 'like', "%{$search}%");
            });
        }

        // Apply sorting and pagination
        $attributes = $attributes->orderBy($request->sortField ?? 'id', $request->sort ?? 'asc')->paginate($limit);

        // Return a collection of ProductBrandResource (including the image)
        return ProductAttributeResource::collection($attributes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductAttributeRequest $request)
    {
        try {
            $brand = $this->repository->storeProductAttribute($request);

            return response()->json([
                'success' => 'Success'
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException('Could not create the product Attribute.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return QueryBuilder::for(ProductAttribute::class)
            ->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductAttributeRequest $request, string $id='')
    {

        try {
            $brand = $this->repository->storeProductAttribute($request,$id);

            return response()->json([
                'success' => true,
                'message' => 'Product Attribute updated successfully',
            ]);      

        } catch (\Exception $e) {
            throw new \RuntimeException('Could not create the product Attribute.'.$e);
        }        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attribute = ProductAttribute::findOrFail($id);
        $attribute->delete();

        return response()->json('Attribute deleted');
    }
}
