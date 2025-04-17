<?php

namespace Modules\Wallet\app\Transformers;

use App\Http\Resources\Seller\Store\StoreDetailsPublicResource;
use App\Http\Resources\Store\StoreShortDetailsResource;
use App\Http\Resources\User\UserDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            "gateway_name" => $this->gateway_name,
            "gateways_options" => json_decode($this->gateways_options),
            "status" => $this->status,
            "details" => $this->details,
            "reject_reason" => $this->reject_reason,
            "attachment" => $this->attachment ? asset("storage/uploads/withdraw/" . basename($this->attachment)) : null,
            "approved_by" => $this->approved_by,
            "approved_at" => $this->approved_at,
            "created_at" => $this->created_at,
            "wallet" => $this->wallet ? new WalletBalanceInfoResource($this->wallet) : null,
            "owner" => $this->owner
                ? (isset($this->owner->store_seller_id)
                    ? new StoreShortDetailsResource($this->owner)
                    : new UserDetailsResource($this->owner))
                : null,
        ];
    }
}
