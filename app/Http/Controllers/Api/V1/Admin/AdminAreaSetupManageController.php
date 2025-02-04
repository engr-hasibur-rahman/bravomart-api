<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AreaCreateRequest;
use App\Http\Resources\Admin\AreaDetailsResource;
use App\Http\Resources\Admin\AreaResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Interfaces\ComAreaInterface;
use App\Interfaces\TranslationInterface;
use App\Services\AreaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAreaSetupManageController extends Controller
{
    public function __construct(
        protected ComAreaInterface     $areaRepo,
        protected TranslationInterface $transRepo,
        protected AreaService          $areaService,
    )
    {
    }

    public function index(Request $request)
    {
        $areas = $this->areaRepo->getPaginatedList(
            $request->limit ?? 10,
            $request->page ?? 1,
            app()->getLocale() ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
        return response()->json([
            'data' => AreaResource::collection($areas),
            'meta' => new PaginationResource($areas),
        ]);
    }

    public function store(AreaCreateRequest $request): JsonResponse
    {
        try {
            $area = $this->areaRepo->store($this->areaService->prepareAddData($request));
            $this->transRepo->storeTranslation($request, $area->id, 'App\Models\StoreArea', $this->areaRepo->translationKeys());

            return $this->success(translate('messages.save_success', ['name' => 'Area']));
        } catch (\Exception $e) {
            return $this->failed(translate('messages.save_failed', ['name' => 'Area']));
        }
    }

    public function show(Request $request)
    {
        $area = $this->areaRepo->getById($request->id);
        return response()->json(new AreaDetailsResource($area));
    }

    public function update(AreaCreateRequest $request): JsonResponse
    {
        try {
            $area = $this->areaRepo->update($this->areaService->prepareAddData($request), $request->id);
            $this->transRepo->updateTranslation($request, $area->id, 'App\Models\StoreArea', $this->areaRepo->translationKeys());
            return $this->success(translate('messages.update_success', ['name' => 'Area']));
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

    public function destroy(string $id): JsonResponse
    {
        $this->areaRepo->delete($id);
        return $this->success(translate('messages.delete_success'));
    }
}
