<?php

namespace App\Http\Resources\Customer;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerProfileResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->fullname,
            'phone' => $this->phone,
            'email' => $this->email,
            'birth_day' => $this->birth_day,
            'gender' => $this->gender,
            'image' => $this->image,
            'image_url' => ImageModifier::generateImageUrl($this->image),
            'status' => $this->status,
            'email_verified' => (bool)$this->email_verified,
        ];
    }
}
