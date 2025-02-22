<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderRefundReasonResource extends JsonResource
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
        $translation = $this->related_translations->where('language', $language);
        return [
            'id' => $this->id,
            'value' => $this->id,
            "label" => !empty($translation) && $translation->where('key', 'reason')->first()
                ? $translation->where('key', 'reason')->first()->value
                : $this->reason, // If language is empty or not provided attribute
        ];
    }
}
