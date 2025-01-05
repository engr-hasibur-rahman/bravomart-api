<?php

namespace App\Http\Resources\Product;

use App\Actions\ImageModifier;
use App\Actions\MultipleImageModifier;
use App\Http\Resources\Com\Product\ProductBrandPublicResource;
use App\Http\Resources\Com\Product\ProductCategoryPublicResource;
use App\Http\Resources\Com\Translation\ProductTranslationResource;
use App\Http\Resources\Tag\TagPublicResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'store' => $this->store ? $this->store->name : '',
            'category' => new ProductCategoryPublicResource($this->category),
            'brand' => new ProductBrandPublicResource($this->brand),
            'unit' => new ProductBrandPublicResource($this->unit),
            'tag' => new TagPublicResource($this->tag),
            'type' => $this->type,
            'behaviour' => $this->behaviour,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'image_url' => ImageModifier::generateImageUrl($this->image),
            'gallery_images' => $this->gallery_images,
            'gallery_images_urls' => MultipleImageModifier::multipleImageModifier($this->gallery_images),
            'warranty' => $this->warranty,
            'return_in_days' => $this->return_in_days,
            'return_text' => $this->return_text,
            'allow_change_in_mind' => $this->allow_change_in_mind,
            'cash_on_delivery' => $this->cash_on_delivery,
            'variants' => ProductVariantPublicResource::collection($this->variants),
            'views' => $this->views,
            'status' => $this->status,
            'available_time_starts' => $this->available_time_starts,
            'available_time_ends' => $this->available_time_ends,
            'wishlist' => auth('api_customer')->check() ? $this->wishlist : false, // Check if the customer is logged in,
            "translations" => ProductTranslationResource::collection($this->related_translations->groupBy('language')),
        ];
    }
}
