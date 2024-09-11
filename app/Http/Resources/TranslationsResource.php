<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class TranslationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */

     public function toArray($request)
    {
       // Safely access the translations property
       $translations = optional($this->translations)->groupBy('language') ?? [];

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

       return $transformedData;
    }
}
