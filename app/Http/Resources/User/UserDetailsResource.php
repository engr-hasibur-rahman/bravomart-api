<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
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
            'phone' => $this->phone,
            'email' => $this->email,
            'image' => $this->image,
            'status' => $this->status,
            'email_verified' => $this->email_verified
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
