<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminSliderResource extends JsonResource
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
            "title" => $this->id,
            "sub_title" => $this->id,
            "description" => $this->id,
            "image" => $this->id,
            "button_text" => $this->id,
            "button_url" => $this->id,
            "redirect_url" => $this->id,
            "order" => $this->id,
            "status" => $this->id,
            "created_by" => $this->id,
            "updated_by" => $this->id,
            "created_at" => $this->id,
            "updated_at" => $this->id,
        ];
    }
}
