<?php

namespace App\Repositories;

use App\Interfaces\DepartmentManageInterface;
use App\Models\Department;

class DepartmentManageRepository implements DepartmentManageInterface
{
    public function __construct(protected Department $department)
    {
    }

    public function getPaginatedDepartments(int|string $perPage, string $search, string $sortField, string $sort)
    {
        $query = Department::query();

        // Apply search filter if a search parameter exists
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Apply sorting
        $query->orderBy($sortField, $sort);

        // Paginate the results
        return $query->paginate($perPage);
    }

    public function store(array $data)
    {
        try {
            $department = $this->department->create($data);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getDepartmentById(int|string $id)
    {
        try {
            $department = $this->department->findorfail($id);
            return $department;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data)
    {
        try {
            $department = $this->department->findorfail($data['id']);
            if ($department) {
                $department->update($data);
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete(int|string $id)
    {
        try {
            $department = $this->department->findOrFail($id);
            $department->delete();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
