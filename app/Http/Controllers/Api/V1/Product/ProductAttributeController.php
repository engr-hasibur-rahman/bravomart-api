<?php

namespace App\Http\Controllers\Api\V1\Product;

use App\Enums\StoreType;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAttributeRequest;
use App\Http\Resources\Product\ProductAttributeResource;
use App\Models\ProductAttribute;
use App\Repositories\ProductAttributeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class ProductAttributeController extends Controller
{
    public function __construct(
        public ProductAttributeRepository $repository
    )
    {
    }

    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $language = $request->language ?? DEFAULT_LANGUAGE;
        $search = $request->search;

        $limit = $request->limit ?? 10;

        $attributes = ProductAttribute::leftJoin('translations', function ($join) use ($language) {
            $join->on('product_attributes.id', '=', 'translations.translatable_id')
                ->where('translations.translatable_type', '=', ProductAttribute::class)
                ->where('translations.language', '=', $language)
                ->where('translations.key', '=', 'name');
        })
            ->select('product_attributes.*',
                DB::raw('COALESCE(translations.value, product_attributes.name) as name'));

        // Apply search filter if search parameter exists
        if ($search) {
            $attributes->where(function ($query) use ($search) {
                $query->where('translations.value', 'like', "%{$search}%")
                    ->orWhere('product_attributes.name', 'like', "%{$search}%");
            });
        }

        // Apply sorting and pagination
        $attributes = $attributes->orderBy($request->sortField ?? 'id', $request->sort ?? 'asc')->paginate($limit);

        // Return a collection of ProductBrandResource (including the image)
        return ProductAttributeResource::collection($attributes);
    }

    public function store(ProductAttributeRequest $request)
    {
        try {
            $attribute = $this->repository->storeProductAttribute($request);
            return $this->success(translate('messages.save_success', ['name' => $attribute->name]));

        } catch (\Exception $e) {
            return $this->failed(translate('messages.save_failed', ['name' => 'Product Attribute']));
        }
    }

    public function show(Request $request)
    {
        $attribute = ProductAttribute::findOrFail($request->id);
        return response()->json(new ProductAttributeResource($attribute));
    }

    public function update(ProductAttributeRequest $request)
    {

        try {
            $attribute = $this->repository->storeProductAttribute($request);
            return $this->success(translate('messages.update_success', ['name' => $attribute->name]));

        } catch (\Exception $e) {
            return $this->failed(translate('messages.update_failed', ['name' => 'Product Attribute']));
        }
    }

    public function status_update(Request $request)
    {
        $attribute = ProductAttribute::findOrFail($request->id);
        $data_name = $attribute->name;
        $attribute->status = !$attribute->status;
        $attribute->save();
        return response()->json([
            'success' => true,
            'message' => 'Product Attribute: ' . $data_name . ' status Changed successfully',
            'status' => $attribute->status
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        $attribute = ProductAttribute::findOrFail($request->id);
        $data_name = $attribute->name;
        $attribute->translations()->delete();
        $attribute->delete();

        return $this->success(translate('messages.delete_success'));
    }


    public function storeAttributeValue(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attribute_id' => 'required|exists:product_attributes,id',
            'value' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->failed($validator->errors());
        }
        try {
            $this->repository->storeAttributeValues($request->all());
            return $this->success(translate('messages.save_success', ['name' => 'Attribute Value']));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function typeWiseAttributes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:' . implode(',', array_column(StoreType::cases(), 'value')),
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'errors' => 'Invalid request! Type must be one of: ' . implode(',', array_column(StoreType::cases(), 'value')),
            ]);
        }
        try {
            $attributes = ProductAttribute::with('attributeValues')
                ->where('product_type', $request->type)
                ->where('status', 1)
                ->get();
            return response()->json(ProductAttributeResource::Collection($attributes));
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
