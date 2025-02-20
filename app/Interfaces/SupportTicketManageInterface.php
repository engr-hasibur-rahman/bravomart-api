<?php

namespace App\Interfaces;
interface SupportTicketManageInterface
{
    public function getTickets(array $filters);

    public function getSellerStoreTickets(array $filters);

    public function getCustomerTickets(array $filters);

    public function createTicket(array $data);

    public function getTicketById($ticketId);

    public function addMessage(array $messageDetails);

    public function updateTicket(array $data);

    public function resolveTicket($ticketId);

    public function getTicketMessages(array $data);

    public function getAdminTicketMessages(array $data);

    public function markMessageAsRead($messageId);
}
