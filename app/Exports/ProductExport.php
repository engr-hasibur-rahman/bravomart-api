<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    protected $shopIds;
    protected $productIds;

    /**
     * Constructor to accept selected shop IDs and product IDs (optional)
     */
    public function __construct(array $shopIds = [], array $productIds = [])
    {
        $this->shopIds = $shopIds;
        $this->productIds = $productIds;
    }

    /**
     * Get the collection of products based on selected IDs
     */
    public function collection()
    {
        if (!empty($this->productIds)) {
            return Product::whereIn('id', $this->productIds)
                ->select(
                    "id",
                    "store_id",
                    "category_id",
                    "brand_id",
                    "unit_id",
                    "tag_id",
                    "name",
                    "slug",
                    "warranty",
                    "return_in_days",
                    "type",
                    "cash_on_delivery",
                    "behaviour",
                    "delivery_time_min",
                    "delivery_time_max",
                    "max_cart_qty",
                    "order_count",
                    "views",
                    "status",
                    "available_time_starts",
                    "available_time_ends"
                )
                ->get();
        }

        if (!empty($this->shopIds)) {
            return Product::whereIn('store_id', $this->shopIds)
                ->select(
                    "id",
                    "store_id",
                    "category_id",
                    "brand_id",
                    "unit_id",
                    "tag_id",
                    "name",
                    "slug",
                    "warranty",
                    "return_in_days",
                    "type",
                    "cash_on_delivery",
                    "behaviour",
                    "delivery_time_min",
                    "delivery_time_max",
                    "max_cart_qty",
                    "order_count",
                    "views",
                    "status",
                    "available_time_starts",
                    "available_time_ends"
                )
                ->get();
        }

        // If no shop IDs or product IDs are provided, export all products
        return Product::select(
            "id",
            "store_id",
            "category_id",
            "brand_id",
            "unit_id",
            "tag_id",
            "name",
            "slug",
            "warranty",
            "return_in_days",
            "type",
            "cash_on_delivery",
            "behaviour",
            "delivery_time_min",
            "delivery_time_max",
            "max_cart_qty",
            "order_count",
            "views",
            "status",
            "available_time_starts",
            "available_time_ends"
        )->get();
    }

    /**
     * Define column headings for the Excel file
     */
    public function headings(): array
    {
        return [
            "id",
            "store_id",
            "category_id",
            "brand_id",
            "unit_id",
            "tag_id",
            "name",
            "slug",
            "warranty",
            "return_in_days",
            "type",
            "cash_on_delivery",
            "behaviour",
            "delivery_time_min",
            "delivery_time_max",
            "max_cart_qty",
            "order_count",
            "views",
            "status",
            "available_time_starts",
            "available_time_ends",
        ];
    }
}
