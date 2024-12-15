<?php

namespace App\Repositories;

use App\Interfaces\CountryManageInterface;
use App\Models\Country;

class CountryManageRepository implements CountryManageInterface
{
    public function __construct(protected Country $country)
    {

    }

    public function getCountries(array $filters)
    {
        // Start building the query
        $query = $this->country->query()->with('states.cities.areas');

        // Filter by country name
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }
        // Filter by country code
        if (!empty($filters['code'])) {
            $query->where('code', 'like', '%' . $filters['code'] . '%');
        }
        // Filter by active status
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        // Filter by region
        if (!empty($filters['region'])) {
            $query->where('region', $filters['region']);
        }

        // Sorting by requested parameter
        $sortBy = $filters['sortBy'] ?? 'id';
        $sortOrder = $filters['sortOrder'] ?? 'asc';
        $query->orderBy($sortBy, $sortOrder);

        // Return paginated results
        $perPage = $filters['perPage'] ?? 10;
        return $query->paginate($perPage);
    }

    public function setCountry(array $data)
    {
        try {
            $this->country->create($data);
            return true;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getCountryById(int $id)
    {
        try {
            $country = $this->country->with('states.cities.areas')->findOrFail($id);
            return $country;
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

    public function updateCountryById(array $data)
    {
        try {
            $country = $this->country->findOrFail($data['id']);
            $country->update($data);
            return true;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteCountry(int $id)
    {
            $country = $this->country->findOrFail($id);
            $country->delete();
            return true;
    }
}
