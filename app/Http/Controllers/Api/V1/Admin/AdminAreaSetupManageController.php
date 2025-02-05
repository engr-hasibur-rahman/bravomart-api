<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAreaChargeRequest;
use App\Http\Requests\AreaCreateRequest;
use App\Http\Requests\StoreAreaSettingsRequest;
use App\Http\Resources\Admin\AreaDetailsResource;
use App\Http\Resources\Admin\AreaResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Interfaces\ComAreaInterface;
use App\Interfaces\TranslationInterface;
use App\Models\StoreArea;
use App\Models\StoreAreaSetting;
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

    public function changeStatus(Request $request)
    {
        try {
            $area = StoreArea::findOrFail($request->id);
            $area->status = !$area->status;
            $area->save();
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


    public function updateStoreAreaSetting(StoreAreaSettingsRequest $request)
    {
        try {
            $storeAreaSetting = StoreAreaSetting::updateOrCreate(
                ['store_area_id' => $request->store_area_id], // Condition to check existing record
                $request->all() // Data to insert/update
            );

            return response()->json([
                'status' => true,
                'message' => __('messages.update_success', ['name' => 'Store Area Settings']),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('messages.update_failed', ['name' => 'Store Area Settings']),
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function storeAreaSettingsDetails(Request $request)
    {
        $storeAreaSettings = StoreAreaSetting::where('store_area_id', $request->store_area_id)->first();
        if ($storeAreaSettings) {
            return response()->json($storeAreaSettings, 200);
        } else {
            return response()->json(['message' => __('messages.data_not_found')], 404);
        }
    }

    public function addAreaCharges(AddAreaChargeRequest $request)
    {

    }


}
