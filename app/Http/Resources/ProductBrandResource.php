<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ProductBrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        $language = $request->language ? $request->language : null;

        if ($language) {
            $translations = $this->translations->where('language', $language)->keyBy('key');

            return [
                'id' => $this->id,
                'brand_name' => $translations->get('brand_name')->value ?? '',
                'brand_slug' => $translations->get('brand_slug')->value ?? '',
                'meta_title' => $translations->get('meta_title')->value ?? '',
                'meta_description' => $translations->get('meta_description')->value ?? '',
                'brand_logo' => $this->brand_logo ?? '',
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
        } else {
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
}
