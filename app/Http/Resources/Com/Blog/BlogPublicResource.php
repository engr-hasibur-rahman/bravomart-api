<?php

namespace App\Http\Resources\Com\Blog;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogPublicResource extends JsonResource
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
            "category" => $this->category?->name,
            "title" => $this->title,
            "slug" => $this->slug,
            "description" => $this->description,
            "image_url" => ImageModifier::generateImageUrl($this->image),
            "tag_name" => $this->tag_name,
            "meta_title" => $this->meta_title,
            "meta_description" => $this->meta_description,
            "meta_keywords" => $this->meta_keywords,
            "meta_image" => ImageModifier::generateImageUrl($this->meta_image),
            'created_at' => $this->created_at->format('F d, Y')
        ];
    }
}
