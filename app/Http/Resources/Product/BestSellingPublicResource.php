<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BestSellingPublicResource extends JsonResource
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

        ];

    }
}
