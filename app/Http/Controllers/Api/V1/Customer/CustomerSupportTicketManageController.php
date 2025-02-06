<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportTicketRequest;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Com\SupportTicket\SupportTicketDetailsResource;
use App\Http\Resources\Com\SupportTicket\SupportTicketMessageResource;
use App\Http\Resources\Com\SupportTicket\SupportTicketResource;
use App\Interfaces\SupportTicketManageInterface;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerSupportTicketManageController extends Controller
{
    public function __construct(protected SupportTicketManageInterface $ticketRepo)
    {

    }

    /* ----------------------------------------------------------- Support Ticket -------------------------------------------------- */
    public function index(Request $request)
    {
        try {
            $filters = $request->only([
                'search',
                'priority',
                'department_id',
                'status',
                'per_page',
            ]);
            $tickets = $this->ticketRepo->getCustomerTickets($filters);
            return response()->json([
                'data' => SupportTicketResource::collection($tickets),
                'meta' => new PaginationResource($tickets)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $ticketId = $request->input('id');
            $ticket = $this->ticketRepo->getTicketById($ticketId);
            return response()->json([
                'data' => new SupportTicketDetailsResource($ticket)
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function store(SupportTicketRequest $request)
    {
        if (!auth('api_customer')->check()) {
            unauthorized_response();
        }
        try {
            $request['user_id'] = auth('api_customer')->user()->id;
            $ticket = $this->ticketRepo->createTicket($request->all());
            return response()->json([
                'message' => __('messages.save_success', ['name' => 'Support Ticket']),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'department_id' => 'nullable|exists:departments,id',
            'title' => 'nullable|string|max:255',
            'priority' => 'nullable|in:low,high,medium,urgent',
            'subject' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ],400);
        }
        $isClosed = Ticket::findorfail($request->input('id'))->pluck('status')->contains(0);
        if ($isClosed) {
            return response()->json([
                'message' => __('messages.ticket.closed')
            ],422);
        }
        try {
            $this->ticketRepo->updateTicket($request->only([
                'id',
                'department_id',
                'title',
                'subject'
            ]));
            return response()->json([
                'message' => __('messages.update_success', ['name' => 'Support Ticket']),
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function resolve(Request $request)
    {
        $ticketId = $request->input('ticket_id');
        try {
            $this->ticketRepo->resolveTicket($ticketId);
            return response()->json([
                'message' => __('messages.ticket.resolved'),
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ],500);
        }
    }

    /* ----------------------------------------------------------- Support Ticket Messages -------------------------------------------------- */
    public function addMessage(Request $request)
    {
        if (auth('api_customer')->check()) {
            unauthorized_response();
        }
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
            $filename = 'customer/support-ticket/' . $timestamp . '_' . $email . '_' . $originalName;

            // Save the uploaded file to private storage
            Storage::disk('import')->put($filename, file_get_contents($file->getRealPath()));
        }

        $messageDetails = [
            'ticket_id' => $request->ticket_id,
            'sender_id' => auth('api_customer')->user()->id,
            'sender_role' => 'customer_level',
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
        $file = $request->file('file');
        if ($file) {
            // Generate a filename with a timestamp
            $timestamp = now()->timestamp;
            $email = str_replace(['@', '.'], '_', $authUser->email); // Replace '@' and '.' with underscores
            $filename = 'customer/support-ticket/' . $timestamp . '_' . $email . '_' . $file->getClientOriginalName();
        }
        // Save the uploaded file to private storage
        Storage::disk('import')->put($filename, file_get_contents($file));
        $messageDetails = [
            'ticket_id' => $request->ticket_id,
            'receiver_id' => $authUser->id,
            'sender_role' => $authUser->activity_scope,
            'message' => $request->message,
            'file' => $filename,
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

    public function getTicketMessages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|exists:tickets,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => $validator->errors()
            ]);
        }
        $ticketMessages = $this->ticketRepo->getTicketMessages($request->ticket_id);
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'data' => SupportTicketMessageResource::collection($ticketMessages)
        ]);
    }
}
