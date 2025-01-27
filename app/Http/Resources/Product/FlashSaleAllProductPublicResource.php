<?php

namespace App\Http\Resources\Product;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlashSaleAllProductPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            $this->approvedProducts->map(function ($product) {
                $product = $product->product;
                // Assuming the first variant is used for price calculations
                $originalPrice = $product->variants[0]->price;
                // Calculate the discounted price based on discount type
                $discountedPrice = $this->discount_type === 'percentage'
                    ? $originalPrice - ($originalPrice * ($this->discount_price / 100))
                    : $originalPrice - $this->discount_price;
                // Limit discounted_price to 2 decimal places
                $discountedPrice = round($discountedPrice, 2);
                return [
                    "id" => $product->id,
                    "name" => $product->name,
                    "slug" => $product->slug,
                    "image" => ImageModifier::generateImageUrl($product->image),
                    "price" => $product->variants[0]->price,
                    "discounted_price" => $discountedPrice,
                ];
            })->random(),
        ];
    }
}
