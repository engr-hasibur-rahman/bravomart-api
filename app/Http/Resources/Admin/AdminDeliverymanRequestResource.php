<?php

namespace App\Http\Resources\Admin;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminDeliverymanRequestResource extends JsonResource
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
            'user_id' => $this->deliveryman->id,
            'first_name' => $this->deliveryman->first_name,
            'last_name' => $this->deliveryman->last_name,
            'slug' => $this->deliveryman->slug,
            'phone' => $this->deliveryman->phone,
            'email' => $this->deliveryman->email,
            'activity_scope' => $this->deliveryman->activity_scope,
            'email_verified' => $this->deliveryman->email_verified,
            'image' => ImageModifier::generateImageUrl($this->deliveryman->image),
            'def_lang' => $this->deliveryman->def_lang,
            'identification_type' => $this->identification_type,
            'identification_number' => $this->identification_number,
            'identification_photo_front' => $this->identification_photo_front,
            'identification_photo_back' => $this->identification_photo_back,
            'vehicle_type' => $this->vehicle_type->name,
            'area' => $this->area->name,
            'address' => $this->address,
            'creator' => $this->creator->first_name,
            'updater' => $this->updater->first_name,
            'status' => $this->deliveryman->status,
            'created_at' => $this->deliveryman->created_at,
            'updated_at' => $this->deliveryman->updated_at,
        ];
    }
}
