<?php

namespace App\Http\Resources\Product;

use App\Actions\ImageModifier;
use App\Actions\MultipleImageModifier;
use App\Http\Resources\Com\Product\ProductBrandPublicResource;
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
        return [
            'id' => $this->id,
            'store' => $this->store,
//            'category' => new ProductCategoryPublicResource($this->category),
            "category" => [
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
                "created_by" => $this->category->display_order,
                "updated_by" => $this->category->updated_by,
                "status" => $this->category->status,
                "created_at" => $this->category->created_at,
                "updated_at" => $this->category->updated_at
            ],
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
            'translations' => $this->related_translations,
        ];
    }
}
