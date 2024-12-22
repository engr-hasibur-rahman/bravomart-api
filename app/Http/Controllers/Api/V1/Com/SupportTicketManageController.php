<?php

namespace App\Http\Controllers\Api\V1\Com;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportTicketRequest;
use App\Http\Resources\Com\SupportTicket\SupportTicketDetailsPublicResource;
use App\Http\Resources\Com\SupportTicket\SupportTicketPublicResource;
use App\Interfaces\SupportTicketManageInterface;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupportTicketManageController extends Controller
{
    public function __construct(protected SupportTicketManageInterface $ticketRepo)
    {

    }
    /* ----------------------------------------------------------- Support Ticket -------------------------------------------------- */
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

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'department_id' => 'nullable|exists:departments,id',
            'title' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => $validator->errors()
            ]);
        }
        $isClosed = Ticket::findorfail($request->input('id'))->pluck('status')->contains(0);
        if ($isClosed) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => __('messages.ticket.closed')
            ]);
        }
        try {
            $this->ticketRepo->updateTicket($request->only([
                'id',
                'department_id',
                'title',
                'subject'
            ]));
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.update_success', ['name' => 'Support Ticket']),
            ]);
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
        try {
            $this->ticketRepo->resolveTicket($ticketId);
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => __('messages.ticket.resolved'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }
    /* ----------------------------------------------------------- Support Ticket Messages -------------------------------------------------- */
    public function addMessage(Request $request, $ticketId)
    {
        $request->validate([
            'message' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,png,jpeg,webp,zip|max:2048'
        ]);

        $messageDetails = [
            'ticket_id' => $ticketId,
            'sender_id' => auth()->id(),
            'sender_role' => auth()->user()->role,
            'message' => $request->message
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('ticket-attachments', $filename, 'public');
            $messageDetails['file'] = $filename;
        }

        $message = $this->ticketRepo->addMessage($messageDetails);

        return response()->json([
            'status' => 'success',
            'message' => 'Message added successfully',
            'data' => $message
        ], 201);
    }
}
