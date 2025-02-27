<?php

namespace App\Http\Resources\Admin;

use App\Actions\ImageModifier;
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
            "title" => $this->title,
            "sub_title" => $this->sub_title,
            "description" => $this->description,
            "image_url" => ImageModifier::generateImageUrl($this->image),
            "button_text" => $this->button_text,
            "button_url" => $this->button_url,
            "redirect_url" => $this->redirect_url,
            "order" => $this->order,
            "status" => $this->status,
            "created_by" => $this->created_by,
            "updated_by" => $this->updated_by,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
