<?php

namespace App\Http\Controllers\Api\V1\Com;

use App\Http\Controllers\Controller;
use App\Http\Requests\AreaCreateRequest;
use App\Http\Resources\ComAreaResource;
use App\Repositories\ComAreaRepository;
use App\Services\AreaService;
use App\Models\ComArea;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function __construct(
        protected ComAreaRepository $repository,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $language = app()->getLocale() ?? DEFAULT_LANGUAGE;
        $search = $request->search;

        $limit = $request->limit ?? 10;

        //$model->getTable().
        $attributes = ComArea::leftJoin('translations', function ($join) use ($language) {
            $join->on('com_areas.id', '=', 'translations.translatable_id')
                ->where('translations.translatable_type', '=', ComArea::class)
                ->where('translations.language', '=', $language)
                ->where('translations.key', '=', 'name');
        })
            ->select('product_attributes.*', 
            DB::raw('COALESCE(translations.value, com_areas.name) as name'));

        // Apply search filter if search parameter exists
        if ($search) {
            $attributes->where(function ($query) use ($search) {
                $query->where(DB::raw('concat(com_areas.name,translations.value)'), 'like', "%{$search}%");
            });
        }

        // Apply sorting and pagination
        $attributes = $attributes->orderBy($request->sortField ?? 'id', $request->sort ?? 'asc')->paginate($limit);

        // Return a collection of ProductBrandResource (including the image)
        return ComAreaResource::collection($attributes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaCreateRequest $request)
    {
        try {
            $attribute = $this->repository->storeArea($request);

            return $this->success(translate('messages.save_success', ['name' => $attribute->name]));

        } catch (\Exception $e) {
            return $this->failed(translate('messages.save_failed', ['name' => 'Area']));
            //return $e;
            //Text Added
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return QueryBuilder::for(ComArea::class)
            ->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaCreateRequest $request, string $id='')
    {

        try {

            $attribute = $this->repository->storeProductAttribute($request);

            return $this->success(translate('messages.update_success', ['name' => $attribute->attribute_name]));

        } catch (\Exception $e) {
            return $this->failed(translate('messages.update_failed', ['name' => 'Area']));
        }        
    }
    
    public function status_update(Request $request)
    {
        $attribute = ComArea::findOrFail($request->id);
        $data_name =$attribute->attribute_name;
        $attribute->status = !$attribute->status;
        $attribute->save();
        return response()->json([
            'success' => true,
            'message' => 'Product Attribute: '.$data_name.' status Changed successfully',
            'status' => $attribute->status
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        $attribute = ComArea::findOrFail($request->id);
        $data_name =$attribute->attribute_name;
        $attribute->translations()->delete();
        $attribute->delete();

        return $this->success(translate('messages.delete_success', ['name' => $data_name]));
    }
}
