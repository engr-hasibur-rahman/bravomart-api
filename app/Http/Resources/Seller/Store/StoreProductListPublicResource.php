<?php

namespace App\Http\Resources\Seller\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreProductListPublicResource extends JsonResource
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
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->variants->isNotEmpty() ? $this->variants[0]->price : null,
            'special_price' => $this->variants->isNotEmpty() ? $this->variants[0]->special_price : null,
            'wishlist' => auth('api_customer')->check() ? $this->wishlist : false, // Check if the customer is logged in,
        ];
    }
}
