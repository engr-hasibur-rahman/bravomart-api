<?php

namespace App\Http\Resources\Product;

use App\Actions\ImageModifier;
use App\Actions\MultipleImageModifier;
use App\Http\Resources\Com\Product\ProductBrandPublicResource;
use App\Http\Resources\Com\Product\ProductCategoryPublicResource;
use App\Http\Resources\Store\StoreShortDetailsResource;
use App\Http\Resources\Tag\TagPublicResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
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
            'store' => new StoreShortDetailsResource($this->store),
            'category' => new ProductCategoryPublicResource($this->category),
            'brand' => new ProductBrandPublicResource($this->brand),
            'unit' => new ProductBrandPublicResource($this->unit),
            'tag' => new TagPublicResource($this->tag),
            'type' => $this->type,
            'behaviour' => $this->behaviour,
            'name' => !empty($translation) && $translation->where('key', 'name')->first()
                ? $translation->where('key', 'name')->first()->value
                : $this->name, // If language is empty or not provided attribute
            'slug' => $this->slug,
            'description' => !empty($translation) && $translation->where('key', 'description')->first()
                ? $translation->where('key', 'description')->first()->value
                : $this->description, // If language is empty or not provided attribute
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
            'attributes' => $this->attributes,
            'children' => ProductVariantPublicResource::collection($this->variants),
            'views' => $this->views,
            'status' => $this->status,
            'available_time_starts' => $this->available_time_starts,
            'available_time_ends' => $this->available_time_ends,
            "manufacture_date" => $this->manufacture_date,
            "expiry_date" => $this->expiry_date,
            "is_featured" => (int)$this->is_featured
        ];
    }
}
