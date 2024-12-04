<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductManageInterface
{
    public function getPaginatedProduct(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters);
    public function store(array $data);
    public function update(array $data);
    public function getProductById(int|string $id);
    public function storeTranslation(Request $request, int|string $refid, string $refPath, array  $colNames);
    public function translationKeys();
    public function delete(int|string $id);
    public function records(bool $onlyDeleted);
}
