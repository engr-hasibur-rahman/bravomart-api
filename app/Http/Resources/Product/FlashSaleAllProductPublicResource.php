<?php

namespace App\Http\Resources\Product;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlashSaleAllProductPublicResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Get the associated product
        $product = $this->product;

        // Get the variants for the current product
        $variants = $product->variants;

        // Assuming the first variant is used for price calculations
        $originalPrice = $variants->isNotEmpty() ? $variants[0]->price : 0;

        // Calculate the discounted price based on discount type
        $discountedPrice = $this->discount_type === 'percentage'
            ? $originalPrice - ($originalPrice * ($this->discount_price / 100))
            : $originalPrice - $this->discount_price;

        // Limit discounted_price to 2 decimal places
        $discountedPrice = round($discountedPrice, 2);

        // Calculate discount percentage
        $discountPercentage = $originalPrice > 0 && $discountedPrice < $originalPrice
            ? round((($originalPrice - $discountedPrice) / $originalPrice) * 100, 2)
            : null;

        // Calculate stock sum
        $stock = $variants->isNotEmpty() ? $variants->sum('stock_quantity') : null;

        // Get single variant if there's only one
        $singleVariant = $variants->count() === 1 ? [$variants->first()] : [];

        return [
            "id" => $product->id,
            "name" => $product->name,
            "slug" => $product->slug,
            "image" => ImageModifier::generateImageUrl($product->image),
            "price" => $originalPrice,
            "special_price" => $discountedPrice,
            "discount_percentage" => $discountPercentage,
            "stock" => $stock,
            "singleVariant" => $singleVariant,
        ];
    }
}
