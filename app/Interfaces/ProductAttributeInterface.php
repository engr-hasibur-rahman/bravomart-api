<?php

namespace App\Interfaces;
use Illuminate\Http\Request;

interface  ProductAttributeInterface{
    public function getPaginatedAttribute(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters);
    public function store(array $data);
}