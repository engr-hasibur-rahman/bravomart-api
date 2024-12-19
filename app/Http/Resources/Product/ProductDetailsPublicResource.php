<?php

namespace App\Http\Resources\Product;

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
        return [
            'id' => $this->id,
            'store' => $this->store,
            'category' => $this->category,
            'brand' => $this->brand,
            'unit' => $this->unit,
            'tag' => $this->tag,
            'type' => $this->type,
            'behaviour' => $this->behaviour,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'gallery_images' => $this->gallery_images,
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
            'variants' => $this->variants ?: null,
            'views' => $this->views,
            'status' => $this->status,
            'available_time_starts' => $this->available_time_starts,
            'available_time_ends' => $this->available_time_ends,
            'translations' => $this->related_translations,
        ];
    }
}
