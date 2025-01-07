<?php

namespace App\Repositories;

use App\Interfaces\InventoryRepositoryInterface;
use App\Models\Product;

class InventoryRepository implements InventoryRepositoryInterface
{
    public function getInventories(array $filters)
    {
        $inventories = Product::query();
        // Search by name, slug, or description
        if (isset($filters['search'])) {
            $searchTerm = $filters['search'];
            $inventories->where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('slug', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }
        // Filter by category
        if (isset($filters['category_id'])) {
            $inventories->where('category_id', $filters['category_id']);
        }
        // Filter by brand
        if (isset($filters['brand_id'])) {
            $inventories->where('brand_id', $filters['brand_id']);
        }
        // Filter by type
        if (isset($filters['type'])) {
            $inventories->where('type', $filters['type']);
        }
        // Filter by stock status
        if (isset($filters['stock_status'])) {
            if ($filters['stock_status'] === 'low_stock') {
                $inventories->lowStock(); // Scope for low stock
            } elseif ($filters['stock_status'] === 'out_of_stock') {
                $inventories->outOfStock(); // Scope for out of stock
            }
        }
        // Filter by store (for admin to filter by seller's store)
        if (isset($filters['store_id'])) {
            $inventories->where('store_id', $filters['store_id']);
        }
        return $inventories->with(['category', 'brand', 'variants', 'store'])->paginate($filters['per_page'] ?? 10);
    }
}
