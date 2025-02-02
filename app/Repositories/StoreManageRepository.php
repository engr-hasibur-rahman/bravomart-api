<?php

namespace App\Repositories;

use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Product\BestSellingPublicResource;
use App\Http\Resources\Product\ProductDetailsPublicResource;
use App\Interfaces\StoreManageInterface;
use App\Models\Banner;
use App\Models\Store;
use App\Models\DeliveryMan;
use App\Models\Order;
use App\Models\OrderActivity;
use App\Models\OrderPackage;
use App\Models\Product;
use App\Models\Translation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Subscription\app\Models\StoreSubscription;
use Modules\Subscription\app\Models\Subscription;
use Modules\Subscription\app\Models\SubscriptionHistory;

class StoreManageRepository implements StoreManageInterface
{
    public function __construct(protected Store $store, protected Translation $translation)
    {
    }

    public function translationKeys(): mixed
    {
        return $this->store->translationKeys;
    }

    public function model(): string
    {
        return Store::class;
    }

    public function getAllStores(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        $store = Store::leftJoin('translations as name_translations', function ($join) use ($language) {
            $join->on('stores.id', '=', 'name_translations.translatable_id')
                ->where('name_translations.translatable_type', '=', Store::class)
                ->where('name_translations.language', '=', $language)
                ->where('name_translations.key', '=', 'name');
        })->select(
            'stores.*',
            DB::raw('COALESCE(name_translations.value, stores.name) as name'),
        );

        // Apply search filter if search parameter exists
        if ($search) {
            $store->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', stores.name, name_translations.value)"), 'like', "%{$search}%");
            });
        }
        // Apply sorting and pagination
        // Return the result
        return $store->with(['merchant', 'area', 'related_translations'])
            ->orderBy($sortField, $sort)
            ->paginate($limit);
    }

    public function getAuthSellerStores(int|string $limit, int $page, string $language, string $search, string $sortField, string $sort, array $filters)
    {
        $store = Store::leftJoin('translations as name_translations', function ($join) use ($language) {
            $join->on('stores.id', '=', 'name_translations.translatable_id')
                ->where('name_translations.translatable_type', '=', Store::class)
                ->where('name_translations.language', '=', $language)
                ->where('name_translations.key', '=', 'name');
        })->select(
            'stores.*',
            DB::raw('COALESCE(name_translations.value, stores.name) as name'),
        );

        // Apply search filter if search parameter exists
        if ($search) {
            $store->where(function ($query) use ($search) {
                $query->where(DB::raw("CONCAT_WS(' ', stores.name, name_translations.value)"), 'like', "%{$search}%");
            });
        }
        // Apply sorting and pagination
        // Return the result
        return $store
            ->where('deleted_at', null)
            ->where('store_seller_id', auth('api')->id())
            ->where('status', 1)
            ->orderBy($sortField, $sort)
            ->paginate($limit);
    }

    public function storeForAuthSeller(array $data)
    {
        try {
            $data = Arr::except($data, ['translations']);
            $data['store_seller_id'] = auth('api')->id();
            $store = Store::create($data);

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
                StoreSubscription::create([
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
            $store = Store::create($data);
            return $store->id;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getStoreById(int|string $id)
    {
        try {
            $store = Store::with(['related_translations', 'merchant', 'area', 'activeSubscription'])->findorfail($id);
            if ($store) {
                return $store;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data)
    {
        $data['updated_by'] = auth('api')->id();
        try {
            $store = Store::findOrFail($data['id']);
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
            $store = Store::findOrFail($data['id']);
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
            $store = Store::findOrFail($id);
            $this->deleteTranslation($store->id, Store::class);
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
                    $records = Store::onlyTrashed()->get();
                    break;

                default:
                    $records = Store::withTrashed()->get();
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

        $stores = Store::with('related_translations') // Load all related translations
        ->where('store_seller_id', $seller_id)
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
        $storeBelongsToSeller = Store::with(['merchant'])
            ->where('store_seller_id', $seller_id)
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
        $store['best_selling'] = $this->getBestSellingProduct($store->id);
        $store['deliverymen'] = $this->storeWiseDeliveryman($store->id);
        return $store;
    }

    private function storeWiseDeliveryman(int $storeId)
    {
        if ($storeId) {
            $totalDeliveryman = DeliveryMan::where('store_id', $storeId)->where('status', 'approved')->count();
            return $totalDeliveryman;
        } else {
            return [];
        }
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

    private function getBestSellingProduct(int $storeId)
    {
        $bestSellingProducts = Product::where('store_id', $storeId)
            ->where('status', 'approved')
            ->where('deleted_at', null)
            ->orderByDesc('order_count')
            ->limit(5)
            ->get();
        return $bestSellingProducts;
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
            $stores = Store::where('store_seller_id', $SellerId)->get();
        } else {
            $stores = Store::where('status', 1)->get();
        }
        return $stores;
    }

    public function approveStores(array $ids)
    {
        try {
            $stores = Store::whereIn('id', $ids)
                ->where('deleted_at', null)
                ->where('status', 0)
                ->orWhere('status', 2)
                ->update([
                    'status' => 1
                ]);
            return $stores > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function changeStatus(array $data)
    {
        try {
            $store = Store::where('id', $data['id'])
                ->where('deleted_at', null)
                ->update([
                    'status' => $data['status']
                ]);
            return $store > 0;
        } catch (\Exception $e) {
            return false;
        }
    }
}
