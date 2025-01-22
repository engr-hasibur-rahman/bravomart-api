<?php

namespace App\Repositories;

use App\Interfaces\StoreManageInterface;
use App\Models\Banner;
use App\Models\ComMerchantStore;
use App\Models\Order;
use App\Models\OrderActivity;
use App\Models\OrderPackage;
use App\Models\Product;
use App\Models\Translation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Subscription\app\Models\ComMerchantStoresSubscription;
use Modules\Subscription\app\Models\Subscription;
use Modules\Subscription\app\Models\SubscriptionHistory;

class StoreManageRepository implements StoreManageInterface
{
    public function __construct(protected ComMerchantStore $store, protected Translation $translation)
    {
    }

    public function translationKeys(): mixed
    {
        return $this->store->translationKeys;
    }

    public function model(): string
    {
        return ComMerchantStore::class;
    }

    public function getAllStores(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        $store = ComMerchantStore::leftJoin('translations as name_translations', function ($join) use ($language) {
            $join->on('com_merchant_stores.id', '=', 'name_translations.translatable_id')
                ->where('name_translations.translatable_type', '=', ComMerchantStore::class)
                ->where('name_translations.language', '=', $language)
                ->where('name_translations.key', '=', 'name');
        })->select(
            'com_merchant_stores.*',
            DB::raw('COALESCE(name_translations.value, com_merchant_stores.name) as name'),
        );

        // Apply search filter if search parameter exists
        if ($search) {
            $store->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', com_merchant_stores.name, name_translations.value)"), 'like', "%{$search}%");
            });
        }
        // Apply sorting and pagination
        // Return the result
        return $store
            ->orderBy($sortField, $sort)
            ->paginate($limit);
    }

    public function getAuthSellerStores(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        $store = ComMerchantStore::leftJoin('translations as name_translations', function ($join) use ($language) {
            $join->on('com_merchant_stores.id', '=', 'name_translations.translatable_id')
                ->where('name_translations.translatable_type', '=', ComMerchantStore::class)
                ->where('name_translations.language', '=', $language)
                ->where('name_translations.key', '=', 'name');
        })->select(
            'com_merchant_stores.*',
            DB::raw('COALESCE(name_translations.value, com_merchant_stores.name) as name'),
        );

        // Apply search filter if search parameter exists
        if ($search) {
            $store->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', com_merchant_stores.name, name_translations.value)"), 'like', "%{$search}%");
            });
        }
        // Apply sorting and pagination
        // Return the result
        return $store
            ->where('deleted_at', null)
            ->where('merchant_id', auth('api')->id())
            ->where('status', 1)
            ->orderBy($sortField, $sort)
            ->paginate($limit);
    }

    public function storeForAuthSeller(array $data)
    {
        try {
            $data = Arr::except($data, ['translations']);
            $data['merchant_id'] = auth('api')->id();
            $store = ComMerchantStore::create($data);

            // if seller select store business type commission or subscription
            if (isset($data['subscription_type']) && !empty($data['subscription_type'])) {
                // create store wise subscription history
                // Validate subscription package
                $subscription_package = Subscription::where('id', $data['subscription_id'])
                    ->where('status', 1)
                    ->first();

                // Create subscription history
                SubscriptionHistory::create([
                    'store_id' => $store->id,
                    'subscription_id' => $subscription_package->id,
                    'name' => $subscription_package->name,
                    'validity' => $subscription_package->validity,
                    'price' => $subscription_package->price,
                    'pos_system' => $subscription_package->pos_system,
                    'self_delivery' => $subscription_package->self_delivery,
                    'mobile_app' => $subscription_package->mobile_app,
                    'live_chat' => $subscription_package->live_chat,
                    'order_limit' => $subscription_package->order_limit,
                    'product_limit' => $subscription_package->product_limit,
                    'product_featured_limit' => $subscription_package->product_featured_limit,
                    'payment_gateway' => $data['payment_gateway'],
                    'payment_status' => $data['payment_status'],
                    'transaction_ref' => $data['transaction_ref'],
                    'manual_image' => $data['manual_image'],
                    'expire_date' => now()->addDays($subscription_package->validity),
                    'status' => 0,
                ]);

                // Create store wise subscription
                ComMerchantStoresSubscription::create([
                    'store_id' => $store->id,
                    'subscription_id' => $subscription_package->id,
                    'name' => $subscription_package->name,
                    'validity' => $subscription_package->validity,
                    'price' => $subscription_package->price,
                    'pos_system' => $subscription_package->pos_system,
                    'self_delivery' => $subscription_package->self_delivery,
                    'mobile_app' => $subscription_package->mobile_app,
                    'live_chat' => $subscription_package->live_chat,
                    'order_limit' => $subscription_package->order_limit,
                    'product_limit' => $subscription_package->product_limit,
                    'product_featured_limit' => $subscription_package->product_featured_limit,
                    'payment_gateway' => $data['payment_gateway'],
                    'payment_status' => $data['payment_status'],
                    'transaction_ref' => $data['transaction_ref'],
                    'manual_image' => $data['manual_image'],
                    'expire_date' => now()->addDays($subscription_package->validity),
                    'status' => 0,
                ]);
            }

            return $store->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(array $data)
    {
        $data['created_by'] = auth('api')->id();
        try {
            $data = Arr::except($data, ['translations']);
            $store = ComMerchantStore::create($data);
            return $store->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getStoreById(int|string $id)
    {
        try {
            $store = ComMerchantStore::findorfail($id);
            $translations = $store->translations()->get()->groupBy('language');
            // Initialize an array to hold the transformed data
            $transformedData = [];
            foreach ($translations as $language => $items) {
                $languageInfo = ['language' => $language];
                /* iterate all Column to Assign Language Value */
                foreach ($this->store->translationKeys as $columnName) {
                    $languageInfo[$columnName] = $items->where('key', $columnName)->first()->value ?? "";
                }
                $transformedData[] = $languageInfo;
            }
            if ($store) {
                return response()->json([
                    "data" => $store->toArray(),
                    'translations' => $transformedData,
                    "massage" => "Data was found"
                ], 201);
            } else {
                return response()->json([
                    "massage" => "Data was not found"
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data)
    {
        $data['updated_by'] = auth('api')->id();
        try {
            $store = ComMerchantStore::findOrFail($data['id']);
            if ($store) {
                $data = Arr::except($data, ['translations']);
                $store->update($data);
                return $store->id;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateForSeller(array $data)
    {
        try {
            $store = ComMerchantStore::findOrFail($data['id']);
            if ($store) {
                $data = Arr::except($data, ['translations']);
                $store->update($data);
                return $store->id;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete(int|string $id)
    {
        try {
            $store = ComMerchantStore::findOrFail($id);
            $this->deleteTranslation($store->id, ComMerchantStore::class);
            $store->delete();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function deleteTranslation(int|string $id, string $translatable_type)
    {
        try {
            $translation = Translation::where('translatable_id', $id)
                ->where('translatable_type', $translatable_type)
                ->delete();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
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

    public function updateTranslation(Request $request, int|string $refid, string $refPath, array $colNames): bool
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

    // Fetch deleted records(true = only trashed records, false = all records with trashed)
    public function records(bool $onlyDeleted = false)
    {
        try {
            switch ($onlyDeleted) {
                case true:
                    $records = ComMerchantStore::onlyTrashed()->get();
                    break;

                default:
                    $records = ComMerchantStore::withTrashed()->get();
                    break;
            }
            return $records;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getOwnerStores()
    {
        if (!auth('api')->check()) {
            unauthorized_response();
        }

        $seller_id = auth('api')->id();

        $stores = ComMerchantStore::with('related_translations') // Load all related translations
        ->where('merchant_id', $seller_id)
            ->where('enable_saling', 1)
            ->where('status', 1)
            ->get();

        return $stores;
    }

    public function checkStoreBelongsToSeller(string $slug)
    {
        if (!auth('api')->check()) {
            unauthorized_response();
        }
        $seller_id = auth('api')->id();
        $storeBelongsToSeller = ComMerchantStore::with(['merchant'])
            ->where('merchant_id', $seller_id)
            ->where('slug', $slug)
            ->first();
        if ($storeBelongsToSeller) {
            return $storeBelongsToSeller;
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 401,
                'message' => __('messages.store.doesnt.belongs.to.seller')
            ]);
        }
    }

    public function storeDashboard(string $slug)
    {
        $store = $this->checkStoreBelongsToSeller($slug);
        $store['products'] = $this->getStoreWiseProducts($store->id);
        $store['banners'] = $this->getStoreWiseBanners($store->id);
        $store['orders'] = $this->getStoreWiseOrders($store->id);
        $store['recent_orders'] = $this->getStoreWiseRecentOrders($store->id);
        return $store;
    }

    private function getStoreWiseProducts(int $storeId)
    {
        if ($storeId) {
            $totalProductsCount = Product::where('store_id', $storeId)->count();
            $approvedProductsCount = Product::where('store_id', $storeId)->where('status', 'approved')->count();
            $pendingProductsCount = Product::where('store_id', $storeId)->where('status', 'pending')->count();
            $inactiveProductsCount = Product::where('store_id', $storeId)->where('status', 'inactive')->count();
            $suspendedProductsCount = Product::where('store_id', $storeId)->where('status', 'suspended')->count();
            return [
                'total' => $totalProductsCount,
                'approved' => $approvedProductsCount,
                'pending' => $pendingProductsCount,
                'inactive' => $inactiveProductsCount,
                'suspended' => $suspendedProductsCount,
            ];
        } else {
            return [];
        }

    }

    private function getStoreWiseOrders(int $storeId)
    {
        if ($storeId) {
            $totalOrders = OrderPackage::where('store_id', $storeId)->count();
            $pendingOrders = OrderPackage::where('store_id', $storeId)->where('status', 'pending')->count();
            return [
                'totalOrders' => $totalOrders,
                'pendingOrders' => $pendingOrders,
            ];
        } else {
            return [];
        }
    }

    private function getStoreWiseRecentOrders(int $storeId)
    {
        if ($storeId) {
            $recentOrders = OrderPackage::where('store_id', $storeId)->latest()->take(5)->get();
            return $recentOrders;
        } else {
            return [];
        }
    }

    private function getStoreWiseBanners(int $storeId)
    {
        return [
            'active' => Banner::where('store_id', $storeId)->where('status', 1)->count()
        ];
    }

    public function getSellerWiseStores(?int $SellerId)
    {
        if ($SellerId) {
            $stores = ComMerchantStore::where('merchant_id', $SellerId)->get();
        } else {
            $stores = ComMerchantStore::where('status', 1)->get();
        }
        return $stores;
    }

    public function approveStores(array $ids)
    {
        try {
            $stores = ComMerchantStore::whereIn('id', $ids)
                ->where('deleted_at', null)
                ->where('status', 0)
                ->orWhere('status', 2)
                ->update([
                    'status' => 1
                ]);
            return $stores > 0;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 404
            ]);
        }
    }
}
