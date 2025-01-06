<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlashSaleRequest;
use App\Http\Resources\Admin\FlashSaleResource;
use App\Services\FlashSaleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FlashSaleManageController extends Controller
{
    protected $flashSaleService;

    public function __construct(FlashSaleService $flashSaleService)
    {
        $this->flashSaleService = $flashSaleService;
    }

    public function createFlashSale(FlashSaleRequest $request): JsonResponse
    {
        $flashSale = $this->flashSaleService->createFlashSale($request->validated());
        if ($flashSale) {
            return response()->json([
                'status' => true,
                'status_code' => 201,
                'message' => __('messages.save_success', ['name' => 'Flash Sale']),
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
            ]);
        }
    }

    public function updateFlashSale(FlashSaleRequest $request): JsonResponse
    {
        $flashSale = $this->flashSaleService->updateFlashSale($request->all());
        if ($flashSale) {
            return response()->json([
                'success' => true,
                'message' => __('messages.update_success', ['name' => 'Flash Sale']),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
            ]);
        }
    }

    public function getFlashSale()
    {
        $flashSales = $this->flashSaleService->getAdminFlashSales();
        return response()->json(FlashSaleResource::collection($flashSales));
    }

    public function changeStatus(Request $request)
    {
        $flashSale = $this->flashSaleService->toggleStatus($request->id);
        if ($flashSale) {
            return response()->json([
                'status' => true,
                'status_code' => 201,
                'message' => __('messages.update_success', ['name' => 'Flash sale status']),

            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
            ]);
        }
    }

    public function deleteFlashSale($id)
    {
        $this->flashSaleService->deleteFlashSale($id);
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => __('messages.delete_success', ['name' => 'Flash sale']),
        ]);
    }
    public function deactivateFlashSale()
    {
       $success = $this->flashSaleService->deactivateExpiredFlashSales();
       if ($success) {
           return response()->json([
               'status' => true,
               'status_code' => 200,
               'message' => __('messages.update_success', ['name' => 'Flash sale status']),
           ]);
       } else {
           return response()->json([
               'status' => false,
               'status_code' => 400,
               'message' => __('messages.update_failed', ['name' => 'Flash sale status'])
           ]);
       }
    }
}
