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

    public function getTicketMessages(array $filters = [])
    {
        $query = $this->ticketMessage->with(['sender', 'receiver']);

        // Apply filters using isset
        if (isset($filters['ticket_id'])) {
            $query->where('ticket_id', $filters['ticket_id']);
        }

        if (isset($filters['sender_id'])) {
            $query->where('sender_id', $filters['sender_id']);
        }

        if (isset($filters['receiver_id'])) {
            $query->where('receiver_id', $filters['receiver_id']);
        }

        if (isset($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        // Apply sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'asc';
        $messages = $query->orderBy($sortBy, $sortOrder)->get();

        // Fetch results
        return $messages;
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
