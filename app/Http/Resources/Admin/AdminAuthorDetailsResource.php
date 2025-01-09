<?php

namespace App\Http\Resources\Admin;

use App\Actions\ImageModifier;
use App\Http\Resources\Translation\AuthorTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminAuthorDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "profile_image" => ImageModifier::generateImageUrl($this->profile_image),
            "cover_image" => ImageModifier::generateImageUrl($this->cover_image),
            "name" => $this->id,
            "slug" => $this->slug,
            "bio" => $this->bio,
            "born_date" => $this->born_date,
            "death_date" => $this->death_date,
            "status" => $this->status,
            "created_by" => $this->creator,
            "translations" => AuthorTranslationResource::collection($this->related_translations->groupBy("language")),
        ];
    }
}
