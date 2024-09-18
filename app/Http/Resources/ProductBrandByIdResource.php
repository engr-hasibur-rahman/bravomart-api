<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ProductBrandByIdResource extends JsonResource
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
                'brand_name' => $items->where('key', 'brand_name')->first()->value ?? null,
                'meta_title' => $items->where('key', 'meta_title')->first()->value ?? null,
                'meta_description' => $items->where('key', 'meta_description')->first()->value ?? null,
            ];

            $transformedData[] = $itemData;
        }

        return [
            'id' => $this->id,
            'brand_name' => $this->brand_name,
            'display_order' => $this->display_order,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'brand_logo' => $this->getFirstMediaUrl('brand_logo'), // Fetch the URL of the brand logo
            'translations' => $transformedData,
        ];
    }
}
