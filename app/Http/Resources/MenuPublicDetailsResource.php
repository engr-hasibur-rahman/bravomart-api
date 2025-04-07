<?php

namespace App\Http\Resources;

use App\Http\Resources\Translation\MenuTranslationResource;
use App\Http\Resources\Translation\OrderRefundReasonTranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuPublicDetailsResource extends JsonResource
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
            "name" => $this->name,
            "url" => $this->url,
            "icon" => $this->icon,
            "position" => $this->position,
            "is_visible" => $this->is_visible,
            'parent_id' => $this->parent_id,
            'parent_path' => $this->parent_path,
            'menu_level' => $this->menu_level,
            'menu_path' => $this->menu_path,
            'childrenRecursive' => MenuPublicViewResource::collection($this->whenLoaded('childrenRecursive')),
            "translations" => MenuTranslationResource::collection($this->related_translations->groupBy('language'))
        ];
    }
}
