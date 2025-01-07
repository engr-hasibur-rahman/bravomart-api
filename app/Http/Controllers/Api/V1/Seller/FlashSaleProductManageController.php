<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlashDealProductRequest;
use App\Http\Resources\Admin\FlashSaleResource;
use App\Http\Resources\Seller\FlashSaleProduct\FlashSaleProductResource;
use App\Services\FlashSaleService;
use Illuminate\Http\Request;

class FlashSaleProductManageController extends Controller
{
    protected $flashSaleService;

    public function __construct(FlashSaleService $flashSaleService)
    {
        $this->flashSaleService = $flashSaleService;
    }

    public function addProductToFlashSale(FlashDealProductRequest $request)
    {
        $success = $this->flashSaleService->associateProductsToFlashSale($request->flash_sale_id, $request->products);
        if ($success) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.request_success', ['name' => 'Products'])
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => __('messages.request_failed', ['name' => 'Products'])
            ]);
        }
    }

    public function getFlashSaleProducts()
    {
        $flashSaleProducts = $this->flashSaleService->getSellerFlashSaleProducts();
        return response()->json(FlashSaleProductResource::collection($flashSaleProducts));
    }

    public function getValidFlashSales()
    {
        $flashSales = $this->flashSaleService->getValidFlashSales();
        return response()->json(FlashSaleResource::collection($flashSales));
    }

}
