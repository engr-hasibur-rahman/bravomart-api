<?php

namespace App\Http\Resources\Product;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlashSaleProductPublicResource extends JsonResource
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
            "title" => $this->title,
            "description" => $this->description,
            "thumbnail_image" => ImageModifier::generateImageUrl($this->thumbnail_image),
            "cover_image" => ImageModifier::generateImageUrl($this->cover_image),
            "discount_type" => $this->discount_type,
            "discount_price" => $this->discount_price,
            "special_price" => $this->special_price,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,
            "product" => $this->approvedProducts->map(function ($product) {
                $product = $product->product;
                // Assuming the first variant is used for price calculations
                $originalPrice = $product->variants[0]->price;
                // Calculate the discounted price based on discount type
                $discountedPrice = $this->discount_type === 'percentage'
                    ? $originalPrice - ($originalPrice * ($this->discount_price / 100))
                    : $originalPrice - $this->discount_price;
                return [
                    "id" => $product->id,
                    "name" => $product->name,
                    "slug" => $product->slug,
                    "image" => ImageModifier::generateImageUrl($product->image),
                    "price" => $product->variants[0]->price,
                    "discounted_price" => $discountedPrice,
                ];
            }),
        ];
    }
}
