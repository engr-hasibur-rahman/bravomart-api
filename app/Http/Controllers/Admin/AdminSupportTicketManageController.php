<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Com\SupportTicket\SupportTicketDetailsResource;
use App\Http\Resources\Com\SupportTicket\SupportTicketResource;
use App\Interfaces\SupportTicketManageInterface;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function replyMessage(Request $request)
    {
        if (auth('api')->check()) {
            unauthorized_response();
        }
        $authUser = auth('api')->user();
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|exists:tickets,id',
            'message' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,png,jpeg,webp,zip|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => $validator->errors()
            ]);
        }
        if ($request->hasFile('file')) {
            // Retrieve the uploaded file
            $file = $request->file('file');

            // Generate a filename with a timestamp
            $timestamp = now()->timestamp;
            $email = str_replace(['@', '.'], '_', auth('api_customer')->user()->email); // Replace '@' and '.' with underscores
            $originalName = $file->getClientOriginalName(); // Get the original file name
            $filename = 'seller/support-ticket/' . $timestamp . '_' . $email . '_' . $originalName;

            // Save the uploaded file to private storage
            Storage::disk('import')->put($filename, file_get_contents($file->getRealPath()));
        }
        $messageDetails = [
            'ticket_id' => $request->ticket_id,
            'receiver_id' => $authUser->id,
            'sender_role' => $authUser->activity_scope,
            'message' => $request->message,
            'file' => $filename ?? null,
        ];
        $message = $this->ticketRepo->addMessage($messageDetails);
        // Update the `updated_at` column of the ticket
        $ticket = Ticket::findorfail($request->ticket_id); // Ensure your repository has this method
        $ticket->touch(); // Update the `updated_at` timestamp

        return response()->json([
            'status' => 'success',
            'message' => __('messages.support_ticket.message.sent'),
            'data' => $message
        ], 201);
    }
}
