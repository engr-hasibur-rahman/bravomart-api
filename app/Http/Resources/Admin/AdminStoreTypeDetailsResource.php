<?php

namespace App\Http\Resources\Admin;

use App\Actions\ImageModifier;
use App\Http\Resources\Translation\StoreTypeTranslationResource;
use App\Http\Resources\Translation\VehicleTypeTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminStoreTypeDetailsResource extends JsonResource
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
            "name" => $this->name,
            "type" => $this->type,
            "image" => $this->image,
            "image_url" => ImageModifier::generateImageUrl($this->image),
            "description" => $this->description,
            "total_stores" => $this->total_stores,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "translations" => StoreTypeTranslationResource::collection($this->related_translations->groupBy('language')),
        ];
    }
}
