<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Translation\FlashSaleTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminFlashSaleDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Get the requested language from the query parameter
        $language = $request->input('language', 'en');
        // Get the translation for the requested language
        $translation = $this->related_translations->where('language', $language);
        return [
            "id" => $this->id,
            "title" => $translation->isNotEmpty()
                ? $translation->where('key', 'title')->first()?->value
                : $this->title,
            "description" => $translation->isNotEmpty()
                ? $translation->where('key', 'description')->first()?->value
                : $this->description,
            "thumbnail_image" => $this->thumbnail_image,
            "cover_image" => $this->cover_image,
            "discount_type" => $this->discount_type,
            "discount_amount" => $this->discount_amount,
            "special_price" => $this->special_price,
            "purchase_limit" => $this->purchase_limit,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,
            "status" => $this->status,
            "related_translations" => FlashSaleTranslationResource::collection($this->related_translations->groupBy('language')),
        ];
    }
}
