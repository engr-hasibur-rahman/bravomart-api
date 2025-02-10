<?php

namespace App\Http\Resources\Product;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopRatedProductPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ['id' => $this->id,
            'store' => $this->store->name ?? null,
            'store_id' => $this->store->id ?? null,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => ImageModifier::generateImageUrl($this->image),
            'stock' => $this->variants->isNotEmpty() ? $this->variants->sum('stock_quantity') : null,
            'price' => optional($this->variants->first())->price,
            'special_price' => optional($this->variants->first())->special_price,
            'singleVariant' => $this->variants->count() === 1 ? [$this->variants->first()] : [],
            'discount_percentage' => $this->variants->isNotEmpty() && optional($this->variants->first())->price > 0
                ? round(((optional($this->variants->first())->price - optional($this->variants->first())->special_price) / optional($this->variants->first())->price) * 100, 2)
                : null,
            'wishlist' => auth('api_customer')->check() ? $this->wishlist : false, // Check if the customer is logged in,
            'rating' => number_format((float) $this->rating, 2, '.', ''),
            'review_count' => $this->review_count,
            ];
    }
}
