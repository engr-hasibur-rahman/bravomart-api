<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\UnitRequest;
use App\Http\Resources\Admin\AdminUnitDetailsResource;
use App\Http\Resources\Admin\AdminUnitResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Interfaces\UnitInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminUnitManageController extends Controller
{
    public function __construct(protected UnitInterface $unitRepo) {}
    public function index(Request $request)
    {
       $units = $this->unitRepo->getPaginatedUnit(
            $request->limit ?? 10,
            $request->page ?? 1,
            $request->language ?? DEFAULT_LANGUAGE,
            $request->search ?? "",
            $request->sortField ?? 'id',
            $request->sort ?? 'asc',
            []
        );
       return response()->json([
           'data'=> AdminUnitResource::collection($units),
           'meta'=> new PaginationResource($units),
       ]);
    }
    public function store(UnitRequest $request): JsonResponse
    {
        $unit = $this->unitRepo->store($request->all());
        createOrUpdateTranslation($request, $unit, 'App\Models\Unit', $this->unitRepo->translationKeys());
        if ($unit) {
            return $this->success(translate('messages.save_success', ['name' => 'Unit']));
        } else {
            return $this->failed(translate('messages.save_failed', ['name' => 'Unit']));
        }
    }
    public function show(Request $request)
    {
        $unit = $this->unitRepo->getUnitById($request->id);
        return response()->json(new AdminUnitDetailsResource($unit));
    }
    public function update(UnitRequest $request)
    {
        $unit = $this->unitRepo->update($request->all());
        createOrUpdateTranslation($request, $unit, 'App\Models\Unit', $this->unitRepo->translationKeys());
        if ($unit) {
            return $this->success(translate('messages.update_success', ['name' => 'Unit']));
        } else {
            return $this->failed(translate('messages.update_failed', ['name' => 'Unit']));
        }
    }
    public function destroy($id)
    {
        $this->unitRepo->delete($id);
        return $this->success(translate('messages.delete_success'));
    }
}
