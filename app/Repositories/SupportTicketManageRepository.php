<?php

namespace App\Repositories;

use App\Interfaces\SupportTicketManageInterface;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\Carbon;

class SupportTicketManageRepository implements SupportTicketManageInterface
{
    public function __construct(protected Ticket $ticket, protected TicketMessage $ticketMessage)
    {

    }

    public function getTickets(array $filters = [])
    {
        $query = $this->ticket->with(['department', 'user', 'messages.sender', 'messages.receiver']);

        // Apply filters using isset
        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
        if (isset($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }
        if (isset($filters['ticket_id'])) {
            return $query->findOrFail($filters['ticket_id']);
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        $tickets = $query->latest()
            ->paginate($filters['per_page'] ?? 10);
        // Sort and fetch results
        return $tickets;
    }

    public function getCustomerTickets(array $filters = [])
    {
        $query = $this->ticket->with(['department', 'messages.sender', 'messages.receiver']);
        if (isset($filters['search']) && !empty($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', $searchTerm)
                    ->orWhere('subject', 'like', $searchTerm);
            });
        }
        if (isset($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }
        if (isset($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        $tickets = $query->where('user_id',auth('api_customer')->user()->id)
            ->latest()
            ->paginate($filters['per_page'] ?? 10);
        // Sort and fetch results
        return $tickets;
    }
    public function getTicketById($ticketId)
    {
        return $this->ticket->with(['department', 'user', 'messages.sender', 'messages.receiver'])->findOrFail($ticketId);
    }
    public function createTicket(array $data)
    {
        try {
            $this->ticket->create($data);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function addMessage(array $messageDetails)
    {
        return $this->ticketMessage->create($messageDetails);
    }
    public function replyMessage(array $messageDetails)
    {
        return $this->ticketMessage->create($messageDetails);
    }

    public function updateTicket(array $data)
    {
        $ticket = $this->ticket->findOrFail($data['id']);
        $ticket->update($data);
        return $ticket;
    }

    public function resolveTicket($ticketId)
    {
        $ticket = $this->ticket->findOrFail($ticketId);
        $ticket->update([
            'status' => 0,
            'resolved_at' => Carbon::now()
        ]);
        return $ticket;
    }

    public function getTicketMessages(int $ticketId)
    {
        $query = $this->ticketMessage->with(['sender', 'receiver', 'ticket']);

        return $this->ticketMessage->where('ticket_id', $ticketId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function markMessageAsRead($messageId)
    {
        $message = $this->ticketMessage->findOrFail($messageId);
        $message->update([
            'is_read' => true,
            'read_at' => Carbon::now()
        ]);
        return $message;
    }

}
