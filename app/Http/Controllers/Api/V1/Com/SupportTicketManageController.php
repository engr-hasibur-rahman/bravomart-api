<?php

namespace App\Http\Controllers\Api\V1\Com;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportTicketRequest;
use App\Http\Resources\Com\SupportTicket\SupportTicketDetailsPublicResource;
use App\Http\Resources\Com\SupportTicket\SupportTicketPublicResource;
use App\Interfaces\SupportTicketManageInterface;
use Illuminate\Http\Request;

class SupportTicketManageController extends Controller
{
    public function __construct(protected SupportTicketManageInterface $ticketRepo)
    {

    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only([
                'user_id',
                'department_id',
                'ticket_id',
                'status',
                'per_page',
            ]);
            $tickets = $this->ticketRepo->getTickets($filters);
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => SupportTicketPublicResource::collection($tickets),
                'pagination' => [
                    'total' => $tickets->total(),
                    'per_page' => $tickets->perPage(),
                    'current_page' => $tickets->currentPage(),
                    'last_page' => $tickets->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function show(Request $request)
    {
        try {
            $ticketId = $request->input('id');
            $ticket = $this->ticketRepo->getTicketById($ticketId);
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.data_found'),
                'data' => new SupportTicketDetailsPublicResource($ticket)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function store(SupportTicketRequest $request)
    {
        if (!auth('api')->check()) {
            unauthorized_response();
        }
        try {
            $request['user_id'] = auth('api')->id();
            $ticket = $this->ticketRepo->createTicket($request->all());
            return response()->json([
                'status' => true,
                'status_code' => 201,
                'message' => __('messages.save_success', ['name' => 'Support Ticket']),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function resolve(Request $request)
    {
        $ticketId = $request->input('ticket_id');
        $ticket = $this->ticketRepo->resolveTicket($ticketId);
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => __('messages.ticket.resolved'),
        ]);
    }
}
