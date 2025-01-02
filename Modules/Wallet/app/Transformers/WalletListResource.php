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
            'walletable_id' => $this->walletable_id,
            'walletable_type' => $this->walletable_type,
            'balance' => $this->balance,
            'status' => $this->status == 1 ? 'active' : 'inactive',
        ];
    }
}
