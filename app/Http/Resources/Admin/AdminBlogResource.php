<?php

namespace App\Http\Resources\Admin;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminBlogResource extends JsonResource
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
            "admin_id" => $this->admin_id,
            "category_id" => $this->category_id,
            "title" => $this->title,
            "slug" => $this->slug,
            "description" => $this->description,
            "image_url" => ImageModifier::generateImageUrl($this->image),
            "views" => $this->views,
            "visibility" => $this->visibility,
            "status" => $this->status,
            "schedule_date" => $this->schedule_date,
            "tag_name" => $this->tag_name,
            "author" => $this->author,
            "category" => $this->category->name ?? null,
            "admin" => $this->admin ? $this->admin->first_name . ' ' . $this->admin->last_name : null,
        ];
    }
}
