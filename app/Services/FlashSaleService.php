<?php
namespace App\Services;

use App\Models\FlashSale;
use App\Models\FlashSaleProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FlashSaleService
{
    public function createFlashSale(array $data): FlashSale
    {
        return FlashSale::create($data);
    }

    public function updateFlashSale(array $data): FlashSale
    {
        $flashSale = FlashSale::findorfail($data['id']);
        $flashSale->update($data);
        return $flashSale;
    }

    public function associateProductToFlashSale(array $data): FlashSaleProduct
    {
        return FlashSaleProduct::create([
            'flash_sale_id' => $data['flash_sale_id'],
            'product_id' => $data['product_id'],
            'store_id' => $data['store_id'] ?? null,
            'created_by' => Auth::id(),
        ]);
    }

    public function getAdminFlashSales()
    {
        return FlashSale::with('products.product')->get();
    }

    public function getSellerFlashSales()
    {
        return FlashSale::where('status', true)
            ->with('products')
            ->whereHas('products', function ($query) {
                $query->where('store_id', auth('api')->store_id);
            })
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
