<?php

namespace App\Http\Resources\Com\SupportTicket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ticket_id' => $this->id,
            'department_id' => $this->department_id,
            'status' => $this->status,
            'priority' => $this->priority,
            'title' => $this->title,
            'subject' => $this->subject,
            'last_updated' => $this->updated_at->diffForHumans(),
        ];
    }
}
