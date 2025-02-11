<?php

namespace App\Http\Resources\Deliveryman;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliverymanDropdownResource extends JsonResource
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
            'value' => $this->id,
            'label' => $this->first_name . ' ' . $this->last_name
        ];
    }
}
