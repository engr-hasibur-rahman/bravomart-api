<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductAttributeRequest;
use App\Http\Resources\ProductAttributeResource;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = $request->limit ?? 10;
        $attributes = QueryBuilder::for(ProductAttribute::class)
        ->paginate($limit);
        return ProductAttributeResource::collection($attributes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductAttributeRequest $request)
    {
        $attribute = ProductAttribute::firstOrCreate([
            'attribute_name' => $request->attribute_name,
        ]);

        return response()->json('Attribute added');
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
    public function update(ProductAttributeRequest $request, string $id)
    {
        $attribute = ProductAttribute::findOrFail($id);
        $attribute->attribute_name = $request->attribute_name;
        $attribute->save();

        return $attribute;
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
