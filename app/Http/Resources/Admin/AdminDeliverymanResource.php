<?php

namespace App\Http\Resources\Admin;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminDeliverymanResource extends JsonResource
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
        $translation = $this->vehicle_type?->related_translations->where('language', $language);
        $area_translation = $this->area?->related_translations->where('language', $language);
        return array_merge(parent::toArray($request), [
            'full_name' => $this->user?->full_name,  // Add your custom variable here
            'vehicle_type' => $this->vehicle_type
                ? array_merge(
                    $this->vehicle_type->toArray(), // convert model to array first
                    [
                        'name' => !empty($translation) && $translation->where('key', 'name')->first()
                            ? $translation->where('key', 'name')->first()->value
                            : $this->vehicle_type->name, // If language is empty or not provided attribute
                    ]
                )
                : null,
            'area' => $this->area ? array_merge($this->area->toArray(), [
                'name' => !empty($area_translation) && $area_translation->where('key', 'name')->first()
                    ? $area_translation->where('key', 'name')->first()->value
                    : $this->area->name, // If language is empty or not provided attribute
            ]): null,
            'identification_photo_front_url' => ImageModifier::generateImageUrl($this->identification_photo_front),
            'identification_photo_back_url' => ImageModifier::generateImageUrl($this->identification_photo_back),
        ]);
    }
}
