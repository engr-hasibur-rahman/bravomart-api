<?php

namespace Modules\Wallet\app\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'wallet_id' => $this->wallet_id,
            'transaction_ref' => $this->transaction_ref,
            'transaction_details' => $this->transaction_details,
            'amount' => $this->amount,
            'type' => $this->type,
            'purpose' => $this->purpose,
            'status' => $this->status == 1 ? 'success' : 'pending',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
