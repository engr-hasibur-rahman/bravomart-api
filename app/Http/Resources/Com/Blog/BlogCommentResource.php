<?php

namespace App\Http\Resources\Com\Blog;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogCommentResource extends JsonResource
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
            "user_name" => $this->user->getFullNameAttribute(),
            "user_image_url" => ImageModifier::generateImageUrl($this->user?->image),
            "comment" => $this->comment,
            "like_count" => $this->like_count,
            "dislike_count" => $this->dislike_count,
            'created_at' => $this->created_at->format('M d, Y \a\t h:i A'),
        ];
    }
}
