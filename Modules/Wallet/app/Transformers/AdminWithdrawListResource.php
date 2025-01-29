<?php

namespace Modules\Wallet\app\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminWithdrawListResource extends JsonResource
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
            "withdraw_gateway_name" => $this->withdrawGateway->name,
            "gateways_options" => json_decode($this->gateways_options),
            "status" => $this->status,
            "details" => $this->details,
            "approved_by" => $this->approved_by,
            "approved_at" => $this->approved_at,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "user" => $this->user->first_name . '' . $this->user->last_name,

        ];
    }
}
