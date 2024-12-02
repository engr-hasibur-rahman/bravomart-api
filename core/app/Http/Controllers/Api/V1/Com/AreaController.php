<?php

namespace App\Http\Controllers\Api\V1\Com;

use App\Http\Controllers\Controller;
use App\Http\Requests\AreaCreateRequest;
use App\Interfaces\ComAreaInterface;
use App\Interfaces\TranslationInterface;
use App\Services\AreaService;
use App\Models\ComArea;
use Illuminate\Http\JsonResponse;
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
     * Display a listing of the resource. Change Update
     */
    public function index(Request $request)
    {
        return $this->areaRepo->getPaginatedList(
            $request->limit ?? 10,
            $request->page ?? 1,
            app()->getLocale() ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaCreateRequest $request): JsonResponse
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
    public function update(AreaCreateRequest $request): JsonResponse
    {
        try {

            $area = $this->areaRepo->update($this->areaService->prepareAddData($request), $request->id);
            $this->transRepo->updateTranslation($request, $area->id, 'App\Models\ComArea', $this->areaRepo->translationKeys());

            return $this->success(translate('messages.update_success', ['name' => $area->name]));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.update_failed', ['name' => 'Area']));
        }
    }

    public function changeStatus(int|string $id, string $status = ""): JsonResponse
    {
        try {
            $this->areaRepo->changeStatus($id, $status = "");
            return $this->success(translate('messages.status_change_success'));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.update_failed', ['name' => 'Area']));
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->areaRepo->delete($id);

        return $this->success(translate('messages.delete_success'));
    }
}
