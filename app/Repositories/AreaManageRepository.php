<?php

namespace App\Repositories;

use App\Interfaces\AreaManageInterface;
use App\Models\Area;

class AreaManageRepository implements AreaManageInterface
{
    public function __construct(protected Area $area)
    {

    }
    public function getAreas(array $filters)
    {
        // Start building the query
        $query = $this->area->query()->with('city');

        // Filter by country name
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        // Filter by City ID
        if (!empty($filters['city_id'])) {
            $query->where('city_id', $filters['city_id']);
        }
        // Filter by active status
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Sorting by requested parameter
        $sortBy = $filters['sortBy'] ?? 'id';
        $sortOrder = $filters['sortOrder'] ?? 'asc';
        $query->orderBy($sortBy, $sortOrder);

        // Return paginated results
        $perPage = $filters['perPage'] ?? 10;
        return $query->paginate($perPage);
    }
    public function setArea(array $data)
    {
        try {
            $this->area->create($data);
            return true;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getAreaById(int $id)
    {
        try {
            $area = $this->area->with('city')->findOrFail($id);
            return $area;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('message.data_not_found'),
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateAreaById(array $data)
    {
        try {
            $area = $this->area->findOrFail($data['id']);
            $area->update($data);
            return true;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function deleteArea(int $id)
    {
        $area = $this->area->findOrFail($id);
        $area->delete();
        return true;
    }

}