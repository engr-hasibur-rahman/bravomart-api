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
            "contact_number" => $this->contact_number,
            "address" => $this->address,
            "area" => $this->area->name,
            "road" => $this->road,
            "house" => $this->house,
            "floor" => $this->floor,
            "postal_code" => $this->postal_code,
            "is_default" => (bool)$this->is_default,
            "status" => $this->status ? "Active" : "Inactive",
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
