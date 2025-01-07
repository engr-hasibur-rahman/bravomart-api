<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\InventoryRepositoryInterface;
use Illuminate\Http\Request;

class InventoryManageController extends Controller
{
    public function __construct(protected InventoryRepositoryInterface $inventoryRepo)
    {

    }

    public function index(Request $request)
    {
        $inventories = $this->inventoryRepo->getInventories();
        return response()->json($inventories);
    }
}
