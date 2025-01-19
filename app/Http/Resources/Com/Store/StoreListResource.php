<?php

namespace App\Http\Resources\Com\Store;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreListResource extends JsonResource
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
            'area_id' => $this->area_id,
            'merchant_id' => $this->merchant_id,
            'store_type' => $this->store_type,
            'name' => $this->name,
            'slug' => $this->slug,
            'phone' => $this->phone,
            'email' => $this->email,
            'logo' => $this->logo,
            'logo_url' => ImageModifier::generateImageUrl($this->logo),
            'banner' => $this->banner,
            'banner_url' => ImageModifier::generateImageUrl($this->banner),
            'address' => $this->address,
            'vat_tax_number' => $this->vat_tax_number,
            'is_featured' => $this->is_featured,
            'opening_time' => $this->opening_time,
            'closing_time' => $this->closing_time,
            'subscription_type' => $this->subscription_type,
            'admin_commission_type' => $this->admin_commission_type,
            'admin_commission_amount' => $this->admin_commission_amount,
            'delivery_charge' => $this->delivery_charge,
            'delivery_time' => $this->delivery_time,
            'delivery_self_system' => $this->delivery_self_system,
            'delivery_take_away' => $this->delivery_take_away,
            'order_minimum' => $this->order_minimum,
            'veg_status' => $this->veg_status,
            'off_day' => $this->off_day,
            'enable_saling' => $this->enable_saling,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_image' => $this->meta_image,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at, // Handles null
            'updated_at' => $this->updated_at, // Handles null
        ];
    }
}
