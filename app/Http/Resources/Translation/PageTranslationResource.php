<?php

namespace App\Http\Resources\Translation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageTranslationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "language_code" => $this->first()->language,
            "title" => safeJsonDecode($this->where('key', 'title')->first()?->value) ,
            "content" => jsonImageModifierFormatter(safeJsonDecode($this->where('key', 'content')->first()?->value)),
            "meta_title" => safeJsonDecode($this->where('key', 'meta_title')->first()?->value) ,
            "meta_description" => safeJsonDecode($this->where('key', 'meta_description')->first()?->value) ,
            "meta_keywords" => safeJsonDecode($this->where('key', 'meta_keywords')->first()?->value) ,
        ];
    }
}
