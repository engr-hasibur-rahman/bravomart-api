<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Translation\SettingsTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminAboutSettingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "slug" => $this->slug,
            "content" => $this->content,
            "translations"=>SettingsTranslationResource::collection($this->related_translations->groupBy('language'))
        ];
    }
}
