<?php

namespace App\Http\Resources\Com\Product;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductStorePublicResource extends JsonResource
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
            "store_type" => $this->store_type,
            "name" => $this->name,
            "slug" => $this->slug,
            "area_id" => $this->area_id,
            "phone" => $this->phone,
            "email" => $this->email,
            "logo" => ImageModifier::generateImageUrl($this->logo),
            "banner" => ImageModifier::generateImageUrl($this->banner),
            "address" => $this->address,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "tax" => $this->tax,
            "tax_number" => $this->tax_number,
            "delivery_time" => $this->delivery_time,
            "meta_title" => $this->meta_title,
            "meta_description" => $this->meta_description,
            "meta_image" => ImageModifier::generateImageUrl($this->meta_image),
            "total_product" => $this->products_count ?? 0
        ];
    }
}
