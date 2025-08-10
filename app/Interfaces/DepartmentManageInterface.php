<?php

namespace App\Interfaces;
interface DepartmentManageInterface
{
    public function getPaginatedDepartments(int|string $perPage, string $search, string $sortField, string $sort);
    public function store(array $data);
    public function getDepartmentById(int|string $id);
    public function update(array $data);
    public function delete(int|string $id);
}
