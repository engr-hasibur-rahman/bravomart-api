<?php

namespace App\Http\Resources\Admin;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminDeliverymanDetailsResource extends JsonResource
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
            'user_id' => $this->user->id,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'slug' => $this->user->slug,
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            'activity_scope' => $this->user->activity_scope,
            'email_verified' => $this->user->email_verified,
            'image' => ImageModifier::generateImageUrl($this->user->image),
            'def_lang' => $this->user->def_lang,
            'identification_type' => $this->identification_type,
            'identification_number' => $this->identification_number,
            'identification_photo_front' => $this->identification_photo_front,
            'identification_photo_back' => $this->identification_photo_back,
            'vehicle_type' => $this->vehicle_type->name,
            'area' => $this->area->name ?? null,
            'address' => $this->address,
            'creator' => $this->creator->first_name,
            'updater' => $this->updater->first_name,
            'status' => $this->user->status,
            'created_at' => $this->user->created_at,
            'updated_at' => $this->user->updated_at,
        ];
    }
}
