<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Modules\Wallet\app\Models\Wallet;

class TrashService
{
    protected array $relatedRelations = [
        'customer' => [
            'wallet',
            'addresses',
            'reviews',
            'tickets',
            'productQueries',
            'blogComments',
            'chats',
            'sentMessages',
            'receivedMessages',
        ],
        'seller' => [
            'stores'
        ],
        'store' => [
            'wallet',
            'chats',
            'sentMessages',
            'receivedMessages',
            'products',
            'tickets',
        ],
        'deliveryman' => [
            'wallet',
        ],
        'product' => [
            'reviews',
            'variants',
            'queries',
        ]
        // Add others later as needed
    ];
    protected array $models = [
        'customer' => Customer::class,
        'seller' => User::class,
        'store' => Store::class,
        'deliveryman' => User::class,
        'product' => Product::class,
        'wallet' => Wallet::class,
    ];

    protected array $scopes = [
        'seller' => 'store_level',
        'deliveryman' => 'delivery_level',
    ];

    protected function getQueryBuilder(string $type)
    {
        $model = $this->models[$type] ?? null;

        if (!$model) {
            throw new \Exception("Invalid model type: {$type}");
        }

        $query = $model::onlyTrashed();

        // Apply activity_scope filtering for shared models
        if (in_array($type, ['seller', 'deliveryman']) && isset($this->scopes[$type])) {
            $query->where('activity_scope', $this->scopes[$type]);
        }

        return $query;
    }

    public function listTrashed(string $type, int $perPage = 10)
    {
        return $this->getQueryBuilder($type)->paginate($perPage);
    }

    public function restore(string $type, array $ids): int
    {
        $query = $this->getQueryBuilder($type)->whereIn('id', $ids);
        $restored = $query->restore();

        $modelClass = $this->models[$type];
        $related = $this->relatedRelations[$type] ?? [];

        foreach ($modelClass::withTrashed()->whereIn('id', $ids)->get() as $item) {
            $this->restoreRelations($type, $item);
        }

        return $restored;
    }

    protected function restoreRelations(string $type, Model $item): void
    {
        $relations = $this->relatedRelations[$type] ?? [];

        foreach ($relations as $relation) {
            if (!method_exists($item, $relation)) {
                continue;
            }

            $relatedItems = $item->$relation()->withTrashed()->get();

            foreach ($relatedItems as $relatedItem) {
                if (method_exists($relatedItem, 'restore') && $relatedItem->trashed()) {
                    $relatedItem->restore();
                }

                // Recursively restore related data for next-level model type (if mapped)
                $relatedType = $this->guessRelatedType(get_class($relatedItem));
                if ($relatedType) {
                    $this->restoreRelations($relatedType, $relatedItem);
                }
            }
        }
    }

    protected function guessRelatedType(string $className): ?string
    {
        foreach ($this->models as $key => $modelClass) {
            if ($className === $modelClass) {
                return $key;
            }
        }

        return null;
    }

    protected function restoreNestedStoreRelations(Model $store): void
    {
        $storeRelations = $this->relatedRelations['store'] ?? [];

        foreach ($storeRelations as $relation) {
            if (method_exists($store, $relation)) {
                $store->$relation()->onlyTrashed()->restore();
            }
        }
    }

    public function forceDelete(string $type, array $ids): int
    {
        return $this->getQueryBuilder($type)->whereIn('id', $ids)->forceDelete();
    }
}
