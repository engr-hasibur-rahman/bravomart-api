<?php

namespace App\Http\Resources\Product;

use App\Actions\ImageModifier;
use App\Actions\MultipleImageModifier;
use App\Http\Resources\Com\Product\ProductBrandPublicResource;
use App\Http\Resources\Com\Product\ProductCategoryPublicResource;
use App\Http\Resources\Com\Product\ProductStorePublicResource;
use App\Http\Resources\Com\Product\ProductUnitPublicResource;
use App\Http\Resources\Com\Translation\ProductTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsPublicResource extends JsonResource
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
            'id' => $this->id,
            'store' => new ProductStorePublicResource($this->store),
            'category' => new ProductCategoryPublicResource($this->category),
            'brand' => new ProductBrandPublicResource($this->brand),
            'unit' => new ProductUnitPublicResource($this->unit),
            'tag' => $this->tag,
            'type' => $this->type,
            'behaviour' => $this->behaviour,
            'name' => $translation->isNotEmpty()
                ? $translation->where('key', 'name')->first()?->value
                : $this->name,
            'slug' => $this->slug,
            'description' => $translation->isNotEmpty()
                ? $translation->where('key', 'description')->first()?->value
                : $this->description,
            'image' => $this->image,
            'image_url' => ImageModifier::generateImageUrl($this->image),
            'gallery_images' => $this->gallery_images,
            'gallery_images_urls' => MultipleImageModifier::multipleImageModifier($this->gallery_images),
            'warranty' => $this->warranty,
            'return_in_days' => $this->return_in_days,
            'return_text' => $this->return_text,
            'allow_change_in_mind' => $this->allow_change_in_mind,
            'cash_on_delivery' => $this->cash_on_delivery,
            'delivery_time_min' => $this->delivery_time_min,
            'delivery_time_max' => $this->delivery_time_max,
            'delivery_time_text' => $this->delivery_time_text,
            'max_cart_qty' => $this->max_cart_qty,
            'order_count' => $this->order_count,
            'variants' => ProductVariantPublicResource::collection($this->variants),
            'views' => $this->views,
            'status' => $this->status,
            'available_time_starts' => $this->available_time_starts,
            'available_time_ends' => $this->available_time_ends,
            'wishlist' => auth('api_customer')->check() ? $this->wishlist : false, // Check if the customer is logged in,
            'rating' => number_format((float) $this->rating, 2, '.', ''),
            'review_count'=>$this->review_count,
            'reviews' => ProductReviewPublicResource::collection($this->reviews)
        ];
    }
}
