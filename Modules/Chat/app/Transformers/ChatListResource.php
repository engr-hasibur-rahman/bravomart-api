<?php

namespace Modules\Chat\app\Transformers;

use App\Actions\ImageModifier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'chat_id'    => $this->chat_id,
            'name'      => $this->receiver?->full_name,
            'image'      => ImageModifier::generateImageUrl($this->receiver?->image_id),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
