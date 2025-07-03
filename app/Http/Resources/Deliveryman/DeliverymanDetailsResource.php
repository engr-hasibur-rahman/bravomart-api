<?php

namespace App\Http\Resources\Deliveryman;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliverymanDetailsResource extends JsonResource
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
            'full_name' => $this->full_name,
            'name' => $this->full_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'image' => $this->image,
            'image_url' => ImageModifier::generateImageUrl($this->image),
            'vehicle_type_id' => $this->deliveryman?->vehicle_type_id,
            'area_id' => $this->deliveryman?->area_id,
            'identification_type' => $this->deliveryman?->identification_type,
            'identification_number' => $this->deliveryman?->identification_number,
            'identification_photo_front' => $this->deliveryman?->identification_photo_front,
            'identification_photo_front_url' => ImageModifier::generateImageUrl($this->deliveryman?->identification_photo_front),
            'identification_photo_back' => $this->deliveryman?->identification_photo_back,
            'identification_photo_back_url' => ImageModifier::generateImageUrl($this->deliveryman?->identification_photo_back),
            'status' => $this->status,
            'is_verified' => (int)$this->is_verified,
            'verified_at' => $this->verified_at,
            'is_available' => (bool)$this->is_available,
            'email_verified' => $this->email_verified,
            "account_status" => $this->deactivated_at ? 'deactivated' : 'active',
            "marketing_email" => (bool)$this->marketing_email,
            "started_at" => $this->created_at->format('F d, Y'),
        ];
    }

}
