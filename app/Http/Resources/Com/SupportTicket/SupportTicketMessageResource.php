<?php

namespace App\Http\Resources\Com\SupportTicket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SupportTicketMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ticket_details' => new SupportTicketDetailsResource($this->ticket),
            'sender_details' => new SenderDetailsResource($this->sender),
            'receiver_details' => new ReceiverDetailsResource($this->receiver),
            'message' => [
                'from' => $this->sender ? $this->sender->first_name . ' ' . $this->sender->last_name : ($this->receiver ? $this->receiver->first_name : 'not received yet!'),
                'role' => $this->sender_role ?? $this->receiver_role,
                'message' => $this->message,
                'file' => $this->file ? Storage::disk('import')->url($this->file) : null, // Generate file URL
                'timestamp' => $this->created_at->diffForHumans()
            ]
        ];
    }
}
