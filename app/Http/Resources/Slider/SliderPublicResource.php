<?php

namespace App\Http\Resources\Slider;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderPublicResource extends JsonResource
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
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'description' => $this->description,
            'button_text' => $this->button_text,
            'button_url' => $this->button_url,
            'redirect_url' => $this->redirect_url,
            'image' => $this->image,
            'image_url' => ImageModifier::generateImageUrl($this->image),
            'order' => $this->order,
        ];
    }
}
