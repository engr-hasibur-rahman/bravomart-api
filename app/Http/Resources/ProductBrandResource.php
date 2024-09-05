<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductBrandResource extends JsonResource
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
            'brand_name' => $this->brand_name,
            'brand_slug' => $this->brand_slug,
            'brand_logo' => $this->brand_logo,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'seller_relation_with_brand' => $this->seller_relation_with_brand,
            'authorization_valid_from' => $this->authorization_valid_from,
            'authorization_valid_to' => $this->authorization_valid_to,
            'display_order' => $this->display_order,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
