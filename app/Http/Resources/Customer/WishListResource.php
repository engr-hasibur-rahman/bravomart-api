<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishListResource extends JsonResource
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
            'product_id' => $this->product->id,
            'store' => $this->product->store->name ?? null,
            'name' => $this->product->name,
            'slug' => $this->product->slug,
            'description' => $this->product->description,
            'image' => $this->image,
            'price' => $this->product->variants->isNotEmpty() ? $this->product->variants[0]->price : null,
            'special_price' => $this->product->variants->isNotEmpty() ? $this->product->variants[0]->special_price : null,
        ];
    }
}
