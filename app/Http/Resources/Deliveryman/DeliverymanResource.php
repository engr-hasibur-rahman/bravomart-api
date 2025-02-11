<?php

namespace App\Http\Resources\Deliveryman;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliverymanResource extends JsonResource
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
            "name" => $this->first_name . ' ' . $this->last_name,
            "phone" => $this->phone,
            "email" => $this->email,
            "total_delivered" => $this->total_delivered,
            "last_delivered_location" => $this->last_delivered_location,
            "rating" => number_format((float)$this->rating, 2, '.', ''),
            "review_count" => $this->review_count
        ];
    }
}
