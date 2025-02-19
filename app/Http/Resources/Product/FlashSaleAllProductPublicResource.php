<?php

namespace App\Http\Resources\Product;

use App\Actions\ImageModifier;
use App\Http\Resources\Store\StoreDetailsForOrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlashSaleAllProductPublicResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->product->id,
            "name" => $this->product->name,
            'store' => new StoreDetailsForOrderResource($this->whenLoaded('store')),
            "slug" => $this->product->slug,
            "description" => $this->product->description,
            'image' => $this->product->image,
            'image_url' => ImageModifier::generateImageUrl($this->product->image),
            'stock' => $this->product->variants->isNotEmpty() ? $this->product->variants->sum('stock_quantity') : null,
            'price' => optional($this->product->variants->first())->price,
            'special_price' => optional($this->product->variants->first())->special_price,
            'singleVariant' => $this->product->variants->count() === 1 ? [$this->product->variants->first()] : [],
            'discount_percentage' => $this->product->variants->isNotEmpty() && optional($this->product->variants->first())->price > 0
                ? round(((optional($this->product->variants->first())->price - optional($this->product->variants->first())->special_price) / optional($this->product->variants->first())->price) * 100, 2)
                : null,
            'wishlist' => auth('api_customer')->check() ? $this->product->wishlist : false, // Check if the customer is logged in,
            'rating' => number_format((float) $this->product->rating, 2, '.', ''),
            'review_count'=>$this->product->review_count,
        ];
    }
}
