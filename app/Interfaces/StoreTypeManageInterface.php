<?php

namespace App\Interfaces;

use Illuminate\Support\Facades\Request;

interface StoreTypeManageInterface
{
    public function getAllStoreTypes(array $filters);

    public function getStoreTypeById(int $id);

    public function updateStoreType(array $data);

    public function storeTranslation(Request $request, int|string $refid, string $refPath, array $colNames);

    public function createOrUpdateTranslation(Request $request, int|string $refid, string $refPath, array $colNames);
}
