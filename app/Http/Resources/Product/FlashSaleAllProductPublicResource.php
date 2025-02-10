<?php

namespace App\Http\Resources\Product;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlashSaleAllProductPublicResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->product->id,
            "name" => $this->product->name,
            "slug" => $this->product->name,
            "description" => $this->product->description,
            "image" => ImageModifier::generateImageUrl($this->product->image),
            'stock' => $this->product->variants->isNotEmpty() ? $this->product->variants->sum('stock_quantity') : null,
            'price' => optional($this->product->variants->first())->price,
            'special_price' => optional($this->product->variants->first())->special_price,
            'singleVariant' => $this->product->variants->count() === 1 ? [$this->product->variants->first()] : [],
            'discount_percentage' => $this->product->variants->isNotEmpty() && optional($this->product->variants->first())->price > 0
                ? round(((optional($this->product->variants->first())->price - optional($this->product->variants->first())->special_price) / optional($this->product->variants->first())->price) * 100, 2)
                : null,
            'wishlist' => auth('api_customer')->check() ? $this->product->wishlist : false, // Check if the customer is logged in,
            'rating'=>$this->rating,
            'review_count'=>$this->review_count,
        ];
    }
}
