<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'product_name' => $this->name, // Assuming the Product relation exists
            'store_name' => $this->store->name,
            'type' => $this->type,
            'order_count' => $this->order_count,
            'slug' => $this->slug,
            "variants" => ProductVariantDetailsForStock::collection($this->variants)
        ];
    }
}
