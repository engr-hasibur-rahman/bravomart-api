<?php

namespace App\Http\Resources\Com\Product;

use App\Actions\ImageModifier;
use App\Http\Resources\ProductChildCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryPublicResource extends JsonResource
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
            "category_name" => $this->category_name,
            "category_slug" => $this->category_slug,
            "category_name_paths" => $this->category_name_paths . '/' . $this->category_name,
            "parent_path" => $this->parent_path . '/' . $this->id,
            "parent_id" => $this->parent_id,
            "category_level" => $this->category_level,
            "is_featured" => $this->is_featured,
            "category_thumb" => ImageModifier::generateImageUrl($this->category_thumb),
            "category_banner" => ImageModifier::generateImageUrl($this->category_banner),
            "meta_title" => $this->meta_title,
            "meta_description" => $this->meta_description,
            "display_order" => $this->display_order,
        ];
//        return parent::toArray($request);
    }

}
