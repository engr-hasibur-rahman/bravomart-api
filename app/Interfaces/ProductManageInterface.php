<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductManageInterface
{
    public function getPaginatedProduct(int|string $store_id, int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters);
    public function store(array $data);
    public function update(array $data);
    public function getProductById(array $data);
    public function storeTranslation(Request $request, int|string $refid, string $refPath, array  $colNames);
    public function translationKeys();
    public function delete(int|string $id);
    public function records(bool $onlyDeleted, string $storeSlug);
    public function changeStatus(array $data);
}
