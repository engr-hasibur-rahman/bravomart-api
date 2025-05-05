<?php

namespace App\Http\Resources;

use App\Http\Resources\Translation\PageTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'id' => $this->id,
            'title' => !empty($translation) && $translation->where('key', 'title')->first()
                ? $translation->where('key', 'title')->first()->value
                : $this->title, // If language is empty or not provided attribute
            'slug' => $this->slug,
            'meta_title' => !empty($translation) && $translation->where('key', 'meta_title')->first()
                ? $translation->where('key', 'meta_title')->first()->value
                : $this->meta_title, // If language is empty or not provided attribute
            'meta_description' => !empty($translation) && $translation->where('key', 'meta_description')->first()
                ? $translation->where('key', 'meta_description')->first()->value
                : $this->meta_description, // If language is empty or not provided attribute
            'meta_keywords' => !empty($translation) && $translation->where('key', 'meta_keywords')->first()
                ? $translation->where('key', 'meta_keywords')->first()->value
                : $this->meta_keywords, // If language is empty or not provided attribute
            'status' => $this->status,
        ];
    }
}
