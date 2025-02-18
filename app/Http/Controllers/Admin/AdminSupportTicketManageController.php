<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Com\SupportTicket\SupportTicketDetailsResource;
use App\Http\Resources\Com\SupportTicket\SupportTicketResource;
use App\Interfaces\SupportTicketManageInterface;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminSupportTicketManageController extends Controller
{
    public function __construct(protected SupportTicketManageInterface $ticketRepo)
    {

    }

    public function index(Request $request)
    {

        $filters = $request->only([
            'customer_id',
            'department_id',
            'ticket_id',
            'status',
            'per_page',
        ]);
        $tickets = $this->ticketRepo->getTickets($filters);
        if ($tickets->count() > 0) {
            return response()->json([
                'data' => SupportTicketResource::collection($tickets),
                'meta' => new PaginationResource($tickets),
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.data_not_found'),
            ], 204);
        }
    }

    public function show(Request $request)
    {
        $ticketId = $request->id;
        $ticket = $this->ticketRepo->getTicketById($ticketId);
        if ($ticket) {
            return response()->json(
                new SupportTicketDetailsResource($ticket)
                , 200);
        } else {
            return response()->json([
                'message' => __('messages.data_not_found'),
            ], 204);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'department_id' => 'nullable|exists:departments,id',
            'title' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
        }
        $isClosed = Ticket::find($request->input('id'))->pluck('status')->contains(0);
        if ($isClosed) {
            return response()->json([
                'message' => __('messages.ticket.closed')
            ], 422);
        }
        $success = $this->ticketRepo->updateTicket($request->only([
            'id',
            'department_id',
            'title',
            'subject'
        ]));
        if ($success) {
            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Support Ticket']),
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.update_failed', ['name' => 'Support Ticket']),
            ], 500);
        }


    }
}
