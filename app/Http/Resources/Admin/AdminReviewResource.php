<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminReviewResource extends JsonResource
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
        $store_translation = $this->store?->related_translations->where('language', $language);
        return [
            "id" => $this->id,
            "reviewable_type" => $this->reviewable_type,
            "reviewer" => $this->customer ? $this->customer->first_name . ' ' . $this->customer->last_name : null,
            "review" => $this->review,
            "rating" => $this->rating,
            "status" => $this->status,
            "like_count" => $this->like_count,
            "dislike_count" => $this->dislike_count,
            "reviewed" => $this->reviewable ?
                ($this->reviewable_type == 'App\Models\User' ?
                    $this->reviewable->first_name . ' ' . $this->reviewable->last_name :
                    ($this->reviewable_type == 'App\Models\Product' ?
                        $this->reviewable->name : null)) : null,
            "store" => !empty($store_translation) && $store_translation->where('key', 'name')->first()
                ? $store_translation->where('key', 'name')->first()->value
                : $this->store?->name,
        ];
    }
}
