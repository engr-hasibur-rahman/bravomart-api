<?php

namespace App\Http\Controllers\Api\V1\Com;

use App\Http\Controllers\Controller;
use App\Http\Requests\AreaCreateRequest;
use App\Interfaces\ComAreaInterface;
use App\Interfaces\TranslationInterface;
use App\Services\AreaService;
use App\Models\ComArea;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function __construct(
        protected ComAreaInterface $areaRepo,
        protected TranslationInterface $transRepo,
        protected AreaService $areaService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Set default values for limit and language
        $limit = $request->limit ?? 10;
        $language = app()->getLocale() ?? DEFAULT_LANGUAGE;
        $search = $request->search;

        // Query the ComArea model with a left join on translations
        $attributes = ComArea::leftJoin('translations', function ($join) use ($language) {
            $join->on('com_areas.id', '=', 'translations.translatable_id')
                ->where('translations.translatable_type', '=', ComArea::class)
                ->where('translations.language', '=', $language)
                ->where('translations.key', '=', 'name');
        })
            ->select(
                'com_areas.*',
                DB::raw('COALESCE(translations.value, com_areas.name) as name')
            );

        // Apply search filter if search parameter exists
        if ($search) {
            $attributes->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', com_areas.name, translations.value)"), 'like', "%{$search}%");
            });
        }

        // Apply sorting and pagination
        $attributes = $attributes
            ->orderBy($request->sortField ?? 'id', $request->sort ?? 'asc')
            ->paginate($limit);

        // Return the result
        return $attributes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaCreateRequest $request)
    {
        try {
            $area = $this->areaRepo->store($this->areaService->prepareAddData($request));
            $this->transRepo->storeTranslation($request, $area->id, 'App\Models\ComArea', $this->areaRepo->translationKeys());

            return $this->success(translate('messages.save_success', ['name' => $request->name]));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.save_failed', ['name' => 'Area']));
            //return $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->areaRepo->getById($id);
        //return QueryBuilder::for(ComArea::class)->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaCreateRequest $request)
    {

        try {

            $area = $this->areaRepo->update($this->areaService->prepareAddData($request), $request->id);
            $this->transRepo->updateTranslation($request, $area->id, 'App\Models\ComArea', $this->areaRepo->translationKeys());

            return $this->success(translate('messages.update_success', ['name' => $area->name]));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.update_failed', ['name' => 'Area']));
            //return $e;
        }
    }

    public function changeStatus(int|string $id, string $status = "")
    {
        try {
            $this->areaRepo->changeStatus($id, $status = "");
            return $this->success(translate('messages.status_change_success'));
        } catch (\Exception $e) {
            //return $this->failed(translate('messages.update_failed', ['name' => 'Area']));
            return $e;
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->areaRepo->delete($id);

        return $this->success(translate('messages.delete_success', ['name' => '']));
    }
}
