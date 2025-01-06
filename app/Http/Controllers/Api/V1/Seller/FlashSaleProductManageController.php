<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Services\FlashSaleService;
use Illuminate\Http\Request;

class FlashSaleProductManageController extends Controller
{
    protected $flashSaleService;

    public function __construct(FlashSaleService $flashSaleService)
    {
        $this->flashSaleService = $flashSaleService;
    }

    public function addProductToFlashSale(Request $request)
    {
        $success = $this->flashSaleService->associateProductsToFlashSale($request->flash_sale_id, $request->products);
        if ($success) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.save_success', ['name' => 'Products'])
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
            ]);
        }
    }

}
