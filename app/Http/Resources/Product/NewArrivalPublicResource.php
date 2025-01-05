<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewArrivalPublicResource extends JsonResource
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
            'store' => $this->store->name,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->variants->isNotEmpty() ? $this->variants[0]->price : null,
            'special_price' => $this->variants->isNotEmpty() ? $this->variants[0]->special_price : null,
            'wishlist' => auth('api_customer')->check() ? $this->wishlist : false, // Check if the customer is logged in,
        ];
    }
}
