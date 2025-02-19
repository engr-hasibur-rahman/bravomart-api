<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "reviewed_by" => new ReviewerPublicResource($this->customer),
            "review" => $this->review,
            "rating" => $this->rating,
            "like_count" => $this->like_count,
            "dislike_count" => $this->dislike_count,
            "reviewed_at" => $this->created_at->diffForHumans(),
        ];
    }
}
