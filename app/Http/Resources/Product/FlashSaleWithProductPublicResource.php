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
                : $this->title,
            "title_color" => $this->title_color,
            "description" => !empty($translation) && $translation->where('key', 'description')->first()
                ? $translation->where('key', 'description')->first()->value
                : $this->description,
            "description_color" => $this->description_color,
            "background_color" => $this->background_color,
            "image" => $this->thumbnail_image,
            "image_url" => ImageModifier::generateImageUrl($this->thumbnail_image),
            "cover_image" => $this->cover_image,
            "cover_image_url" => ImageModifier::generateImageUrl($this->cover_image),
            "discount_type" => $this->discount_type,
            "discount_amount" => $this->discount_amount,
            "special_price" => $this->special_price,
            "button_text" => $this->button_text,
            "button_text_color" => $this->button_text_color,
            "button_hover_color" => $this->button_hover_color,
            "button_bg_color" => $this->button_bg_color,
            "button_url" => $this->button_url,
            "timer_bg_color" => $this->timer_bg_color,
            "timer_text_color" => $this->timer_text_color,
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
                    "type" => $product->type,
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
