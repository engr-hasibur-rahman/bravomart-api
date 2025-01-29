<?php

namespace Modules\Wallet\app\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "amount" => $this->amount,
            "fee" => $this->fee,
            "gateways_options" => json_decode($this->gateways_options),
            "status" => $this->status,
            "details" => $this->details,
            "approved_by" => $this->approved_by,
            "approved_at" => $this->approved_at,
            "withdraw_gateway" => [
                "id" => $this->withdrawGateway->id,
                "name" => $this->withdrawGateway->name,
                "fields" => json_decode($this->withdrawGateway->fields),
                "status" => $this->withdrawGateway->status,
            ],
        ];
    }
}
