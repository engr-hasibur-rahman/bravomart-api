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
            "title" => json_decode($this->where('key', 'title')->first()?->value,true),
            "content" => json_decode($this->where('key', 'content')->first()?->value,true),
            "meta_title" => json_decode($this->where('key', 'meta_title')->first()?->value,true),
            "meta_description" => json_decode($this->where('key', 'meta_description')->first()?->value,true),
            "meta_keywords" => json_decode($this->where('key', 'meta_keywords')->first()?->value,true),
        ];
    }
}
