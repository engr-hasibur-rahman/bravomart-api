<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ProductCategoryByIdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $translations = $this->translations->groupBy('language');

        // Initialize an array to hold the transformed data
        $transformedData = [];

        foreach ($translations as $language => $items) {
            $itemData = [
                'language' => $language,
                'category_name' => $items->where('key', 'category_name')->first()->value ?? null,
                'meta_title' => $items->where('key', 'meta_title')->first()->value ?? null,
                'meta_description' => $items->where('key', 'meta_description')->first()->value ?? null,
            ];
            $transformedData[] = $itemData;
        }
        return [
            'id' => $this->id,
            'category_name' => $this->category_name,
            'display_order' => $this->display_order,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'category_banner' => $this->getFirstMediaUrl('category_banner'), // Fetch the URL of the brand logo
            'category_thumb' => $this->getFirstMediaUrl('category_thumb'), // Fetch the URL of the brand logo
            'parent_id' => $this->parent_id,
            'category_name_paths' => $this->category_name_paths,
            'parent_path' => $this->parent_path,
            'is_featured' => $this->is_featured,
            'translations' => $transformedData,
        ];
    }
}
