<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlashDealProductRequest;
use App\Http\Requests\FlashSaleRequest;
use App\Http\Resources\Admin\AdminFlashSaleDetailsResource;
use App\Http\Resources\Admin\AdminFlashSaleResource;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Seller\FlashSaleProduct\FlashSaleProductResource;
use App\Services\FlashSaleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminFlashSaleManageController extends Controller
{
    protected $flashSaleService;

    public function __construct(FlashSaleService $flashSaleService)
    {
        $this->flashSaleService = $flashSaleService;
    }

    public function createFlashSale(FlashSaleRequest $request): JsonResponse
    {
        $flashSale = $this->flashSaleService->createFlashSale($request->validated());
        $this->flashSaleService->storeTranslation($request, $flashSale, 'App\Models\FlashSale', $this->flashSaleService->translationKeys());
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
        $this->flashSaleService->updateTranslation($request, $flashSale, 'App\Models\FlashSale', $this->flashSaleService->translationKeys());
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

    public function getFlashSale(Request $request)
    {
        $flashSales = $this->flashSaleService->getAdminFlashSales($request->per_page);
        return response()->json([
                'data' => AdminFlashSaleResource::collection($flashSales),
                'meta' => new PaginationResource($flashSales)
            ]
        );
    }

    public function adminAddProductToFlashSale(FlashDealProductRequest $request)
    {
        // check the products exists in store or not
        $productsNotInStore = $this->flashSaleService->checkProductsExistInStore($request->store_id, $request->products);
        if ($productsNotInStore) {
            return response()->json($productsNotInStore);
        }
        // check if the products are already in flash sale
        $existingProducts = $this->flashSaleService->getExistingFlashSaleProducts($request->products);

        if ($existingProducts) {
            return response()->json($existingProducts);
        }
        $data = $this->flashSaleService->associateProductsToFlashSale($request->flash_sale_id, $request->products, $request->store_id);
        if ($data) {
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

    public function FlashSaleDetails(Request $request)
    {
        $flashSales = $this->flashSaleService->getFlashSaleById($request->id);
        return response()->json(new AdminFlashSaleDetailsResource($flashSales));
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
        $flashSale = $this->flashSaleService->deleteFlashSale($id);
        $flashSaleProducts = $this->flashSaleService->deleteFlashSaleProducts($id);
        if ($flashSale && $flashSaleProducts) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.delete_success', ['name' => 'Flash sale']),
            ]);
        } else {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.delete_failed', ['name' => 'Flash sale']),
            ]);
        }

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

    public function flashSaleProductRequest()
    {
        $requests = $this->flashSaleService->getFlashSaleProductRequest();
        return response()->json([
            'data' => FlashSaleProductResource::collection($requests),
            'meta' => new PaginationResource($requests),
        ]);
    }

    public function approveFlashSaleProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:flash_sale_products,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'errors' => $validator->errors()
            ]);
        }
        $success = $this->flashSaleService->approveFlashSaleProductRequest($request->ids);
        if ($success) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.update_success', ['name' => 'Flash sale product request']),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => __('messages.update_failed', ['name' => 'Flash sale product request'])
            ]);
        }
    }

    public function rejectFlashSaleProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'rejection_reason' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'errors' => $validator->errors()
            ]);
        }
        $success = $this->flashSaleService->rejectFlashSaleProductRequest($request->ids, $request->rejection_reason);
        if ($success) {
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.update_success', ['name' => 'Flash sale product request']),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => __('messages.update_failed', ['name' => 'Flash sale product request'])
            ]);
        }
    }
}
