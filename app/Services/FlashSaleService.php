<?php

namespace App\Services;

use App\Models\FlashSale;
use App\Models\FlashSaleProduct;

class FlashSaleService
{
    public function createFlashSale(array $data)
    {
        FlashSale::create($data);
        return true;
    }

    public function updateFlashSale(array $data)
    {
        $flashSale = FlashSale::findorfail($data['id']);
        $flashSale->update($data);
        return true;
    }

    public function deleteFlashSale($id)
    {
        $flashSale = FlashSale::findorfail($id);
        $flashSale->delete();
        return true;
    }

    public function associateProductsToFlashSale(int $flashSaleId, array $products)
    {
        $bulkData = array_map(function ($product) use ($flashSaleId) {
            return [
                'flash_sale_id' => $flashSaleId,
                'product_id' => $product['product_id'],
                'store_id' => $product['store_id'] ?? null,
                'creator_type' => null,
                'created_by' => auth('api')->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $products);

        FlashSaleProduct::insert($bulkData); // Bulk insert for performance
        return true;
    }

    public function getAdminFlashSales($per_page = 10)
    {
        return FlashSale::paginate($per_page);
    }

    public function getFlashSaleById($id)
    {
        return FlashSale::where('id', $id)->get();
    }

    public function getSellerFlashSaleProducts()
    {
        return FlashSaleProduct::with(['product', 'flashSale'])
            ->where('created_by', auth('api')->id())
            ->get();
    }

    public function getAllFlashSaleProducts($per_page)
    {
        $flashSaleProducts = FlashSaleProduct::with(['flashSale', 'product.variants'])
            ->where('status', 'approved')
            ->whereHas('flashSale', function ($query) {
                $query->where('status', true)
                    ->where('start_time', '<=', now())
                    ->where('end_time', '>=', now());
            })
            ->paginate($per_page ?? 10);
        return $flashSaleProducts;
    }

    public function getValidFlashSales()
    {
        return FlashSale::with(['approvedProducts.product'])
            ->where('status', true) // Ensure the flash sale is active
            ->where('start_time', '<=', now()) // Valid only after the start time
            ->where('end_time', '>=', now()) // Valid only before the end time
            ->orderBy('start_time', 'asc') // Order by the start time
            ->get();
    }

    public function toggleStatus(int $id): FlashSale
    {
        $flashSale = FlashSale::findOrFail($id);
        $flashSale->status = !$flashSale->status;
        $flashSale->save();
        return $flashSale;
    }

    public function deactivateExpiredFlashSales()
    {
        $expiredFlashSales = FlashSale::where('end_time', '<', now())
            ->where('status', true) // Ensure only active flash sales are updated
            ->update(['status' => false]); // Use the existing field name for status

        return $expiredFlashSales > 0; // Return true if any records were updated
    }

    public function getFlashSaleProductRequest()
    {
        $requests = FlashSaleProduct::pending()->paginate(10);
        return $requests;
    }

    public function approveFlashSaleProductRequest(array $productIds): bool
    {
        // Validate input
        if (!empty($productIds) && isset($productIds)) {
            // Bulk update the status to "approved"
            $updated = FlashSaleProduct::whereIn('id', $productIds)
                ->where('status', 'pending')
                ->update([
                    'status' => 'approved',
                    'reviewed_at' => now(),
                    'updated_at' => now()
                ]);
            // Return true if at least one record was updated
            return $updated > 0;
        } else {
            return false;
        }
    }

    public function rejectFlashSaleProductRequest(array $productIds, string $rejectionReason): bool
    {
        // Validate input
        if (!empty($productIds) && isset($productIds) && !empty($rejectionReason)) {
            // Bulk update the status to "rejected" and set the rejection reason
            $updated = FlashSaleProduct::whereIn('id', $productIds)
                ->update([
                    'status' => 'rejected',
                    'rejection_reason' => $rejectionReason,
                    'reviewed_at' => now(),
                    'updated_at' => now()
                ]);
            // Return true if at least one record was updated
            return $updated > 0;
        } else {
            return false;
        }
    }
}
