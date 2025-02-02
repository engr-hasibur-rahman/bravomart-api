<?php

namespace App\Services;

use App\Models\FlashSale;
use App\Models\FlashSaleProduct;
use App\Models\Product;
use App\Models\Translation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;

class FlashSaleService
{
    public function __construct(protected FlashSale $flashSale, protected Translation $translation)
    {
    }

    public function translationKeys(): mixed
    {
        return $this->flashSale->translationKeys;
    }

    public function createFlashSale(array $data)
    {
        $flashSale = FlashSale::create($data);
        return $flashSale->id;
    }

    public function updateFlashSale(array $data)
    {
        $flashSale = FlashSale::findorfail($data['id']);
        $flashSale->update($data);
        return $flashSale->id;
    }

    public function deleteFlashSale($id)
    {
        $flashSale = FlashSale::findorfail($id);
        $flashSale->delete();
        return true;
    }

    public function deleteFlashSaleProducts($id)
    {
        $flashSaleProducts = FlashSaleProduct::where('flash_sale_id', $id)->get();
        if (!empty($flashSaleProducts)) {
            foreach ($flashSaleProducts as $flashSaleProduct) {
                $flashSaleProduct->delete();
            }
            return true;
        } else {
            return false;
        }
    }

    public function associateProductsToFlashSale(int $flashSaleId, array $products, int $storeId, string $rejection_reason = null)
    {
        $bulkData = array_map(function ($product) use ($flashSaleId, $storeId, $rejection_reason) {
            return [
                'flash_sale_id' => $flashSaleId,
                'product_id' => $product,
                'store_id' => $storeId ?? null,
                'status' => $product['status'],
                'rejection_reason' => $product['status'] === 'rejected' ? $rejection_reason : null,
                'created_by' => auth('api')->id(),
                'updated_by' => auth('api')->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $products);

        FlashSaleProduct::insert($bulkData); // Bulk insert for performance
        return true;
    }

    public function getExistingFlashSaleProducts(array $productIds)
    {
        $existingProducts = FlashSaleProduct::whereIn('product_id', $productIds)
            ->with('product:id,name') // Load product names
            ->get();
        if ($existingProducts->isEmpty()) {
            return null; // No existing products found
        }

        $flashSaleId = $existingProducts->first()->flash_sale_id;

        // Check if the flash sale is active
        $flashSale = FlashSale::where('id', $flashSaleId)
            ->where('start_time', '<=', Carbon::now())
            ->where('end_time', '>=', Carbon::now())
            ->first();

        if ($flashSale) {
            return [
                'status' => false,
                'status_code' => 422,
                'message' => 'Some products are already associated with an active flash sale.',
                'existing_products' => $existingProducts->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name ?? 'Unknown',
                        'flash_sale_start' => $item->flashSale->start_time ?? null,
                        'flash_sale_end' => $item->flashSale->end_time ?? null,
                    ];
                }),
            ];
        }
        return null; // No active flash sale found
    }

    public function checkProductsExistInStore(int $storeId, array $productIds)
    {
        $existingProducts = Product::whereIn('id', $productIds)
            ->where('store_id', $storeId)
            ->pluck('id')
            ->toArray();
        // Find missing product IDs
        $missingProducts = array_diff($productIds, $existingProducts);
        if (!empty($missingProducts)) {
            return [
                'status' => false,
                'status_code' => 422,
                'message' => 'Some products do not exist in the given store.',
            ];
        }

        return null;
    }


    public function getAdminFlashSales($per_page = 10)
    {
        return FlashSale::with('related_translations')->paginate($per_page);
    }

    public function getFlashSaleById($id)
    {
        return FlashSale::with('related_translations')->where('id', $id)->first();
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
        return FlashSale::with(['approvedProducts.product', 'related_translations'])
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
        $requests = FlashSaleProduct::with('related_translations')->pending()->paginate(10);
        if (!empty($requests)) {
            return $requests;
        } else {
            return null;
        }
    }

    public function getFlashSaleProductRequestDetails(int $id)
    {
        $requests = FlashSaleProduct::find($id);
        if (!empty($requests)) {
            return $requests;
        } else {
            return null;
        }
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

    public function storeTranslation($request, int|string $refid, string $refPath, array $colNames): bool
    {
        $translations = [];
        if ($request['translations']) {
            foreach ($request['translations'] as $translation) {
                foreach ($colNames as $key) {

                    // Fallback value if translation key does not exist
                    $translatedValue = $translation[$key] ?? null;

                    // Skip translation if the value is NULL
                    if ($translatedValue === null) {
                        continue; // Skip this field if it's NULL
                    }
                    // Collect translation data
                    $translations[] = [
                        'translatable_type' => $refPath,
                        'translatable_id' => $refid,
                        'language' => $translation['language_code'],
                        'key' => $key,
                        'value' => $translatedValue,
                    ];
                }
            }
        }
        if (count($translations)) {
            $this->translation->insert($translations);
        }
        return true;
    }

    public function updateTranslation($request, int|string $refid, string $refPath, array $colNames): bool
    {
        $translations = [];
        if ($request['translations']) {
            foreach ($request['translations'] as $translation) {
                foreach ($colNames as $key) {

                    // Fallback value if translation key does not exist
                    $translatedValue = $translation[$key] ?? null;

                    // Skip translation if the value is NULL
                    if ($translatedValue === null) {
                        continue; // Skip this field if it's NULL
                    }

                    $trans = $this->translation->where('translatable_type', $refPath)->where('translatable_id', $refid)
                        ->where('language', $translation['language_code'])->where('key', $key)->first();
                    if ($trans != null) {
                        $trans->value = $translatedValue;
                        $trans->save();
                    } else {
                        $translations[] = [
                            'translatable_type' => $refPath,
                            'translatable_id' => $refid,
                            'language' => $translation['language_code'],
                            'key' => $key,
                            'value' => $translatedValue,
                        ];
                    }
                }
            }
        }
        if (count($translations)) {
            $this->translation->insert($translations);
        }
        return true;
    }
}
