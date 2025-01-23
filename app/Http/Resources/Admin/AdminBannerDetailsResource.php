<?php

namespace App\Http\Resources\Admin;

use App\Actions\ImageModifier;
use App\Http\Resources\Translation\VehicleTypeTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminBannerDetailsResource extends JsonResource
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
            "user_id" => $this->creator,
            "store_id" => $this->store,
            "title" => $translation ? $translation->where('key', 'title')->first()?->value : $this->title,
            "description" => $translation ? $translation->where('key', 'description')->first()?->value : $this->description,
            "background_image" => ImageModifier::generateImageUrl($this->background_image),
            "thumbnail_image" => ImageModifier::generateImageUrl($this->thumbnail_image),
            "button_text" => $translation ? $translation->where('key', 'button_text')->first()?->value : $this->button_text,
            "button_color" => $this->button_color,
            "redirect_url" => $this->redirect_url,
            "location" => $this->location,
            "type" => $this->type,
            "status" => $this->status,
            "translations" => VehicleTypeTranslationResource::collection($this->related_translations->groupBy('language')),
        ];
    }
}
