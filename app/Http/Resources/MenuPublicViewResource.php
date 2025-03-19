<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuPublicViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'icon' => $this->icon ?? null,
            'position' => $this->position,
            'is_visible' => (bool) $this->is_visible,
        ];
    }
}
