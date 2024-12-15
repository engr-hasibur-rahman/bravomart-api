<?php

namespace App\Repositories;

use App\Interfaces\StateManageInterface;
use App\Models\State;

class StateManageRepository implements StateManageInterface
{
    public function __construct(protected State $state)
    {

    }
    public function getStates(array $filters)
    {
        // Start building the query with relationships
        $query = $this->state->query()->with('country');

        // Filter by state name
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        // Filter by country ID
        if (!empty($filters['country_id'])) {
            $query->where('country_id', $filters['country_id']);
        }

        // Filter by active status
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by timezone
        if (!empty($filters['timezone'])) {
            $query->where('timezone', $filters['timezone']);
        }

        // Sorting by requested parameter
        $sortBy = $filters['sortBy'] ?? 'id';
        $sortOrder = $filters['sortOrder'] ?? 'asc';
        $query->orderBy($sortBy, $sortOrder);

        // Return paginated results
        $perPage = $filters['perPage'] ?? 10;
        return $query->paginate($perPage);
    }
    public function setState(array $data)
    {
        try {
            $this->state->create($data);
            return true;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getStateById(int $id)
    {
        try {
            $state = $this->state->with('country')->findOrFail($id);
            return $state;
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
    public function updateStateById(array $data)
    {
        try {
            $state = $this->state->findOrFail($data['id']);
            $state->update($data);
            return true;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function deleteState(int $id)
    {
        $state = $this->state->findOrFail($id);
        $state->delete();
        return true;
    }
}
