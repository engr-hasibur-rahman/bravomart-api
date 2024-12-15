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
        $sortBy = $filters['sortBy'] ?? 'id'; // Default sort by ID
        $sortOrder = $filters['sortOrder'] ?? 'asc'; // Default order ascending
        $query->orderBy($sortBy, $sortOrder);

        // Return paginated results
        $perPage = $filters['perPage'] ?? 10; // Default items per page
        return $query->paginate($perPage);
    }

    public function setCountry(array $data)
    {
        //dd($data);
        try {
            $this->country->create($data);
            return true;
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred while creating the country.',
                'error' => $e->getMessage()
            ];
        }
    }
}
