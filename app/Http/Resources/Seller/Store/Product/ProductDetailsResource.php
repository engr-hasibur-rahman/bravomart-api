<?php

namespace App\Http\Resources\Seller\Store\Product;

use App\Actions\ImageModifier;
use App\Actions\MultipleImageModifier;
use App\Http\Resources\Admin\SellerListForDropdownResource;
use App\Http\Resources\Com\Translation\ProductTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
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
            "value" => $this->id,
            "label" => $this->name,
            "name" => $this->name,
            "type" => $this->type,
            "behaviour" => $this->behaviour,
            "slug" => $this->slug,
            "description" => $this->description,
            "image" => (int)$this->image,
            "image_url" => ImageModifier::generateImageUrl($this->image),
            "gallery_images" => MultipleImageModifier::multipleImageModifier($this->gallery_images),
            "warranty" => $this->warranty,
            "class" => $this->class,
            "return_in_days" => $this->return_in_days,
            "return_text" => $this->return_text,
            "allow_change_in_mind" => (int)$this->allow_change_in_mind,
            "cash_on_delivery" => $this->cash_on_delivery,
            "delivery_time_min" => $this->delivery_time_min,
            "delivery_time_max" => $this->delivery_time_max,
            "delivery_time_text" => $this->delivery_time_text,
            "max_cart_qty" => $this->max_cart_qty,
            "order_count" => $this->order_count,
            "views" => $this->views,
            "status" => $this->status,
            "available_time_starts" => $this->available_time_starts,
            "available_time_ends" => $this->available_time_ends,
            "manufacture_date" => $this->manufacture_date,
            "expiry_date" => $this->expiry_date,
            "meta_title" => $this->meta_title,
            "meta_description" => $this->meta_description,
            "meta_keywords" => is_array($decodedKeywords = json_decode($this->meta_keywords, true))
                ? implode(',', $decodedKeywords)
                : $this->meta_keywords,
            "meta_image" => ImageModifier::generateImageUrl($this->meta_image),
            "variants" => VariantDetailsResource::collection($this->variants),
            "store" => $this->store,
            "seller" => new SellerListForDropdownResource($this->store->seller),
            "category" => $this->category && $this->category->id
                ? [
                    "id" => $this->category->id,
                    "category_name" => $this->category->category_name,
                    "category_slug" => $this->category->category_slug,
                    "category_name_paths" => $this->category->category_name_paths . '/' . $this->category->category_name,
                    "parent_path" => $this->category->parent_path . '/' . $this->category->id,
                    "parent_id" => $this->category->parent_id,
                    "category_level" => $this->category->category_level,
                    "is_featured" => $this->category->is_featured,
                    "admin_commission_rate" => $this->category->admin_commission_rate,
                    "category_thumb" => $this->category->category_thumb,
                    "category_banner" => $this->category->category_banner,
                    "meta_title" => $this->category->meta_title,
                    "meta_description" => $this->category->meta_description,
                    "display_order" => $this->category->display_order,
                    "created_by" => $this->category->created_by,
                    "updated_by" => $this->category->updated_by,
                    "status" => $this->category->status,
                    "created_at" => $this->category->created_at,
                    "updated_at" => $this->category->updated_at
                ]
                : null,
            "brand" => $this->brand,
            "unit" => $this->unit,
            "attributes" => $this->attributes,
            "translations" => ProductTranslationResource::collection($this->related_translations->groupBy('language')),
        ];
    }
}
