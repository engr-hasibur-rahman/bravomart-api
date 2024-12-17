<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface BannerManageInterface
{
    public function translationKeys();

    public function getPaginatedBanner(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters);

    public function store(array $data);

    public function getBannerById(int|string $id);

    public function update(array $data);

    public function delete(int|string $id);

    public function storeTranslation(Request $request, int|string $refid, string $refPath, array $colNames);

    public function updateTranslation(Request $request, int|string $refid, string $refPath, array $colNames);
}
