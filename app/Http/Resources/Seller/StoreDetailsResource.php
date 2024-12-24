<?php

namespace App\Http\Resources\Seller;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'store_details' => [
                'id' => $this->id,
                'merchant' => [
                    'id' => $this->merchant->user->id,
                    'first_name' => $this->merchant->user->first_name,
                    'last_name' => $this->merchant->user->last_name,
                    'phone' => $this->merchant->user->phone,
                    'email' => $this->merchant->user->email,
                    'email_verified' => (bool)$this->merchant->user->email_verified,
                    'def_lang' => $this->merchant->user->def_lang,
                    'store_owner' => (bool)$this->merchant->user->store_owner,
                    'status' => $this->merchant->user->status,
                ],
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
                'admin_commi_percent' => $this->admin_commi_percent,
                'admin_commi_amount' => $this->admin_commi_amount,
                'delivery_charge' => $this->delivery_charge,
                'delivery_time' => $this->delivery_time,
                'delivery_self_system' => $this->delivery_self_system,
                'delivery_take_away' => $this->delivery_take_away,
                'order_minimum' => $this->order_minimum,
                'veg_status' => $this->veg_status,
                'off_day' => $this->off_day,
                'enable_saling' => (bool)$this->enable_saling,
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description,
                'meta_image' => $this->meta_image,
                'status' => $this->status,
            ],
            'store_summary' => [
                'products_count' => $this->products,
                'banners_count' => $this->banners
            ]
        ];
    }
}
