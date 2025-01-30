<?php

namespace App\Http\Resources\Customer;

use App\Actions\ImageModifier;
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
            'id' => $this->product->id,
            'store' => $this->product->store->name ?? null,
            'name' => $this->product->name,
            'slug' => $this->product->slug,
            'description' => $this->product->description,
            'image' => ImageModifier::generateImageUrl($this->product->image),
            'stock' => $this->product->variants->isNotEmpty() ? $this->product->variants->sum('stock_quantity') : null,
            'price' => optional($this->product->variants->first())->price,
            'special_price' => optional($this->product->variants->first())->special_price,
            'singleVariant' => $this->product->variants->count() === 1 ? [$this->product->variants->first()] : [],
            'discount_percentage' => $this->product->variants->isNotEmpty() && optional($this->product->variants->first())->price > 0
                ? round(((optional($this->product->variants->first())->price - optional($this->product->variants->first())->special_price) / optional($this->product->variants->first())->price) * 100, 2)
                : null,
            'wishlist' => auth('api_customer')->check() ? $this->product->wishlist : false, // Check if the customer is logged in,
        ];
    }
}
