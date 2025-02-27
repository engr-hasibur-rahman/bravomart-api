<?php

namespace Modules\Wallet\app\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWalletDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'owner_type' => $this->owner_type,
            'total_balance' => $this->balance,
            'total_earnings' => $this->earnings,
            'total_withdrawn' => $this->withdrawn,
            'status' => $this->status == 1 ? 'active' : 'inactive',
        ];
    }
}
