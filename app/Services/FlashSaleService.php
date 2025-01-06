<?php

namespace App\Services;

use App\Models\FlashSale;
use App\Models\FlashSaleProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                'created_by' => auth('api')->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $products);

        FlashSaleProduct::insert($bulkData); // Bulk insert for performance

        return true;
    }

    public function getAdminFlashSales()
    {
        return FlashSale::with('products.product')->get();
    }

    public function getSellerFlashSaleProducts()
    {
        return FlashSaleProduct::with(['product','flashSale'])
            ->where('created_by', auth('api')->id())
            ->get();
    }
    public function toggleStatus(int $id): FlashSale
    {
        $flashSale = FlashSale::findOrFail($id);
        $flashSale->status = !$flashSale->status;
        $flashSale->save();

        return $flashSale;
    }
}
