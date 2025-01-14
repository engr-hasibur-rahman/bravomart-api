<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Translation\VehicleTypeTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminVehicleResource extends JsonResource
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
            "name" => $translation ? $translation->where('key', 'name')->first()?->value : $this->name,
            "fuel_type" => $this->fuel_type,
            "average_fuel_cost" => $this->average_fuel_cost,
            "description" => $translation ? $translation->where('key', 'description')->first()?->value : $this->description,
            "status" => $this->status,
            "created_by" => $this->creator->first_name,
            "store" => $this->store->name ?? null,
        ];
    }
}
