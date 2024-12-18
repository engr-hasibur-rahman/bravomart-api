<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\ProductChildCategoryResource;
use Illuminate\Http\JsonResponse;
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
        $language = $request->language;
        $locales = $this->translations->where('language', $language)->keyBy('key')->toArray();
        return [
            'id' => $this->id,
            'label' => $locales['category_name']['value'] ?? $this->category_name,
            'category_name' => $locales['category_name']['value'] ?? $this->category_name,
            'parent_id' => $this->parent_id,
            'category_slug' => $locales['category_slug']['value'] ?? $this->category_slug,
            'category_thumb' => '',
            'meta_title' => $locales['meta_title']['value'] ?? $this->meta_title,
            'meta_description' => $locales['meta_description']['value'] ?? $this->meta_description,
        ];
    }

}
