<?php

namespace App\Interfaces;

interface TagInterface {
    public function getPaginatedTag(int|string $limit,string $search, string $sortField, string $sort);
    public function store(array $data);
    public function getTagById(int|string $id);
    public function update(array $data);
    public function delete(int|string $id);
    
}
