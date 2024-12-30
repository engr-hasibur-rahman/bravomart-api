<?php

namespace App\Http\Resources\Blog;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogListResource extends JsonResource
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
            'blog_title' => $this->title,
            'category' => $this->category->name,
            'slug' => $this->slug,
            'image' => ImageModifier::generateImageUrl($this->image),
            'views' => $this->views,
            'visibility' => $this->visibility,
            'status' => $this->status ? "published" : "draft",
            'schedule_date' => $this->schedule_date,
            'tags' => $this->tag_name,
            'author' => $this->author
        ];
    }

    public function with($request): array
    {
        return [
            'status' => true,
            'status_code' => 200,
            'message' => __('messages.data_found'),
        ];
    }
}
