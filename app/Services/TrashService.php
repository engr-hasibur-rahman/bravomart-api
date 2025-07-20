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
        return $this->getQueryBuilder($type)->whereIn('id', $ids)->restore();
    }

    public function forceDelete(string $type, array $ids): int
    {
        return $this->getQueryBuilder($type)->whereIn('id', $ids)->forceDelete();
    }
}
