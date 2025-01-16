<?php

namespace App\Http\Resources\Com\Seller;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerDetailsPublicResource extends JsonResource
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
            "name" => $this->first_name . '' . $this->last_name,
            "phone" => $this->phone,
            "email" => $this->email,
        ];
    }
}
