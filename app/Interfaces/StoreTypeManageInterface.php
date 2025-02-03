<?php

namespace App\Interfaces;

use Illuminate\Support\Facades\Request;

interface StoreTypeManageInterface
{
    public function getAllStoreTypes(array $filters);

    public function storeTranslation(Request $request, int|string $refid, string $refPath, array $colNames);

    public function updateTranslation(Request $request, int|string $refid, string $refPath, array $colNames);
}
