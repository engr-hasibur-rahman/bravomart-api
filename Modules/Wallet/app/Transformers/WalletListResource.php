<?php

namespace Modules\Wallet\app\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'owner_type' => $this->owner_type == 'App\Models\Customer' ? 'Customer' : 'User',
            'balance' => $this->balance,
            'status' => $this->status,
        ];
    }
}
