<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderRefundRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Get the requested language from the query parameter
        $language = $request->input('language', 'en');
        // Get the translation for the requested language
        $store_translation = $this->store->related_translations->where('language', $language);
        $refund_reason_translation = $this->orderRefundReason->related_translations->where('language', $language);
        return [
            "id" => $this->id,
            "order_id" => $this->order_id,
            "customer_note" => $this->customer_note,
            "status" => $this->status,
            "amount" => $this->amount,
            "store" => !empty($translation) && $translation->where('key', 'name')->first()
                ? $translation->where('key', 'name')->first()->value
                : $this->store?->name,
            "customer" => $this->customer?->getFullNameAttribute(),
            "order_refund_reason" => !empty($translation) && $translation->where('key', 'reason')->first()
                ? $translation->where('key', 'reason')->first()->value
                : $this->orderRefundReason?->reason,
            "file" => asset('storage/' . $this->file) ?? null
        ];
    }
}
