<?php

namespace App\Http\Resources\Com\SupportTicket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketDetailsPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ticket_details' => [
                'ticket_id' => $this->id,
                'status' => $this->status,
                'priority' => $this->priority,
                'title' => $this->title,
                'subject' => $this->subject,
                'last_updated' => $this->updated_at->diffForHumans(),
            ],
            'ticket_messages' => [
                'message' => isset($this->message) && $this->message->isNotEmpty()
                    ? $this->message
                    : 'No messages yet',
            ]
        ];
    }
}
