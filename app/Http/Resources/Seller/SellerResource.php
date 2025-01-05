<?php

namespace App\Http\Resources\Seller;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
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
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "slug" => $this->slug,
            "phone" => $this->phone,
            "email" => $this->email,
            "activity_scope" => $this->activity_scope,
            "email_verified" => (bool)$this->email_verified,
            "image" => ImageModifier::generateImageUrl($this->image),
            "def_lang" => $this->def_lang,
            "store_owner" => (bool)$this->store_owner,
            "merchant_id" => $this->merchant_id,
            "stores" => $this->stores,
            "status" => $this->getStatusText($this->status),
        ];
    }

    private function getStatusText($status)
    {
        switch ($status) {
            case 0:
                return 'Inactive';
            case 1:
                return 'Active';
            case 2:
                return 'Suspended';
            default:
                return 'Unknown'; // Fallback for unexpected status
        }
    }
}
