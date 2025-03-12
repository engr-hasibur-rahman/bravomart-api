<?php

namespace App\Http\Resources\Product;

use App\Actions\ImageModifier;
use App\Http\Resources\Store\StoreDetailsForOrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlashSaleWithProductPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Get the requested language from the query parameter
        $language = $request->input('language', 'en');
        // Get the translation for the requested language
        $translation = $this->related_translations->where('language', $language);
        return [
            "id" => $this->id,
            'store' => new StoreDetailsForOrderResource($this->whenLoaded('store')),
            "title" => !empty($translation) && $translation->where('key', 'title')->first()
                ? $translation->where('key', 'title')->first()->value
                : $this->title, // If language is empty or not provided attribute
            "description" => !empty($translation) && $translation->where('key', 'description')->first()
                ? $translation->where('key', 'description')->first()->value
                : $this->description, // If language is empty or not provided attribute
            "thumbnail_image" => $this->thumbnail_image,
            "thumbnail_image_url" => ImageModifier::generateImageUrl($this->thumbnail_image),
            "cover_image" => $this->cover_image,
            "cover_image_url" => ImageModifier::generateImageUrl($this->cover_image),
            "discount_type" => $this->discount_type,
            "discount_amount" => $this->discount_amount,
            "special_price" => $this->special_price,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,
            "product" => $this->approvedProducts->map(function ($product) {
                $product = $product->product;

                // Get the variants for the current product
                $variants = $product->variants;

                // Assuming the first variant is used for price calculations
                $originalPrice = $variants->isNotEmpty() ? $variants[0]->price : 0;

                // Calculate the discounted price based on discount type
                $discountedPrice = $this->discount_type === 'percentage'
                    ? $originalPrice - ($originalPrice * ($this->discount_amount / 100))
                    : $originalPrice - $this->discount_amount;

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
                    'image' => $this->image,
                    'image_url' => ImageModifier::generateImageUrl($this->image),
                    "price" => $originalPrice,
                    "special_price" => $discountedPrice,
                    "discount_percentage" => $discountPercentage,
                    "stock" => $stock,
                    "singleVariant" => $singleVariant,
                ];
            })->random(),
        ];
    }
}
