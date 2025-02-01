<?php

namespace App\Http\Resources\Admin;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminFlashSaleResource extends JsonResource
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
            "title" => $translation->where('key', 'title')->first()?->value ?? $this->title,
            "cover_image" => ImageModifier::generateImageUrl($this->cover_image),
            "thumbnail_image" => ImageModifier::generateImageUrl($this->thumbnail_image),
            "discount_type" => $this->discount_type,
            "discount_amount" => $this->discount_amount,
            "special_price" => $this->special_price,
            "purchase_limit" => $this->purchase_limit,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,
            "status" => $this->status,
        ];
    }
}
