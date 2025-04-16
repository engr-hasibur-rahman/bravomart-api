<?php

namespace App\Http\Resources\Seller;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerNoticeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "notice_id" => $this->notice?->id,
            "title" => $this->notice?->title,
            "type" => $this->notice?->type,
            "priority" => $this->notice?->priority,
            "status" => $this->notice?->status,
            "created_at" => $this->notice?->created_at->diffForHumans(),
        ];
    }
}
