<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LowStockProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'store' => $this->store->name,
            'slug' => $this->slug,
            'type' => $this->type,
            'variants' => $this->lowStockVariants()->map(function ($variant) {
                return [
                    'product_id' => $variant->product_id,
                    'id' => $variant->id,
                    'sku' => $variant->sku,
                    'stock_quantity' => $variant->stock_quantity,
                    'price' => $variant->price,
                ];
            }),
            'total'=> $this->lowStockVariants()->count(),
        ];
    }
}
