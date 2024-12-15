<?php

namespace App\Repositories;

use App\Interfaces\CityManageInterface;
use App\Models\City;

class CityManageRepository implements CityManageInterface
{
    public function __construct(protected City $city)
    {

    }
    public function getCities(array $filters)
    {
        // Start building the query
        $query = $this->city->query()->with('state');

        // Filter by country name
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        // Filter by State ID
        if (!empty($filters['state_id'])) {
            $query->where('state_id', $filters['state_id']);
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
    public function setCity(array $data)
    {
        try {
            $this->city->create($data);
            return true;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getCityById(int $id)
    {
        try {
            $city = $this->city->with('state')->findOrFail($id);
            return $city;
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
    public function updateCityById(array $data)
    {
        try {
            $city = $this->city->findOrFail($data['id']);
            $city->update($data);
            return true;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function deleteCity(int $id)
    {
        $city = $this->city->findOrFail($id);
        $city->delete();
        return true;
    }
}