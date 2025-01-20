<?php

namespace App\Http\Resources\Seller;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerNoticeDetailsResource extends JsonResource
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
            "message" => $this->message,
            "type" => $this->type,
            "priority" => $this->priority,
            "active_date" => $this->active_date,
            "expire_date" => $this->expire_date,
            "status" => $this->status,
        ];
    }
}
