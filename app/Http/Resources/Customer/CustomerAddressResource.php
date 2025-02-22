<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerAddressResource extends JsonResource
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
            "type" => $this->type,
            "email" => $this->email,
            "contact_number" => $this->contact_number,
            "address" => $this->address,
            "lat" => $this->latitude,
            "long" => $this->longitude,
            "area" => $this->area->name ?? null,
            "road" => $this->road,
            "house" => $this->house,
            "floor" => $this->floor,
            "postal_code" => $this->postal_code,
            "is_default" => (bool)$this->is_default,
            "status" => $this->status,
        ];
    }

    public function with($request): array
    {
        return [
            'message' => __('messages.data_found'),
        ];
    }
}
