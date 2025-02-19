<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportTicketRequest;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Com\SupportTicket\SupportTicketDetailsResource;
use App\Http\Resources\Com\SupportTicket\SupportTicketMessageResource;
use App\Http\Resources\Com\SupportTicket\SupportTicketResource;
use App\Interfaces\SupportTicketManageInterface;
use App\Models\Store;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SellerSupportTicketManageController extends Controller
{
    public function __construct(protected SupportTicketManageInterface $ticketRepo)
    {

    }

    /* ----------------------------------------------------------- Support Ticket -------------------------------------------------- */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id' => 'required|integer|exists:stores,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $filters = $request->only([
            'store_id',
            'department_id',
            'ticket_id',
            'status',
            'priority',
            'per_page',
        ]);
        $tickets = $this->ticketRepo->getSellerStoreTickets($filters);
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
        $seller = auth('api')->user();
        $seller_stores = Store::where('store_seller_id', $seller->id)->pluck('id');
        $ticket = $this->ticketRepo->getTicketById($ticketId);
        if ($seller_stores->contains($ticket->store_id)) {
            return response()->json(new SupportTicketDetailsResource($ticket), 200);
        } else {
            return response()->json(['message' => __('messages.data_not_found')], 404);
        }
    }

    public function store(Request $request)
    {
        if (!auth('api')->check()) {
            unauthorized_response();
        }
        $validator = Validator::make($request->all(), [
            'store_id' => 'required|exists:stores,id',
            'department_id' => 'nullable|exists:departments,id',
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'priority' => 'nullable|in:high,medium,low,urgent',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $seller = auth('api')->user();
        $seller_stores = Store::where('store_seller_id', $seller->id)->pluck('id');
        if (!$seller_stores->contains($request->store_id)) {
            return response()->json([
                'message' => __('messages.store.doesnt.belongs.to.seller'),
            ], 422);
        }
        $request['store_id'] = $request->store_id;

        $ticket = $this->ticketRepo->createTicket($request->all());
        return response()->json([
            'status' => true,
            'status_code' => 201,
            'message' => __('messages.save_success', ['name' => 'Support Ticket']),
        ], 201);


    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:tickets,id',
            'department_id' => 'nullable|exists:departments,id',
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'priority' => 'nullable|in:high,medium,low,urgent',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $ticket = Ticket::find($request->id);
        $seller = auth('api')->user();
        $seller_stores = Store::where('store_seller_id', $seller->id)->pluck('id');
        $isClosed = $ticket->pluck('status')->contains(0);
        if ($isClosed) {
            return response()->json([
                'message' => __('messages.ticket.closed')
            ], 422);
        }
        if (!$seller_stores->contains($ticket->store_id)) {
            return response()->json([
                'message' => __('messages.ticket_does_not_belongs_to_this_store'),
            ], 422);
        }
        $success = $this->ticketRepo->updateTicket($request->only([
            'id',
            'department_id',
            'title',
            'subject',
            'priority'
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

    public function resolve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|integer|exists:tickets,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $ticketId = $request->ticket_id;
        $seller = auth('api')->user();
        $seller_stores = Store::where('store_seller_id', $seller->id)->pluck('id');
        $ticket = Ticket::find($ticketId);
        if (!$seller_stores->contains($ticket->store_id)) {
            return response()->json([
                'message' => __('messages.ticket_does_not_belongs_to_this_store'),
            ], 422);
        }
        $success = $this->ticketRepo->resolveTicket($ticketId);
        if ($success) {
            return response()->json([
                'message' => __('messages.ticket.resolved'),
            ], 200);
        } else {
            return response()->json([
                'message' => __('messages.update_failed', ['name' => 'Support Ticket status']),
            ], 200);
        }
    }

    /* ----------------------------------------------------------- Support Ticket Messages -------------------------------------------------- */
    public function addMessage(Request $request)
    {
        if (!auth('api')->check()) {
            return unauthorized_response();
        }

        $seller = auth('api')->user();

        $validatedData = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'store_id' => 'required|exists:stores,id',
            'message' => 'required|string|max:1500',
            'file' => 'nullable|file|mimes:jpg,png,jpeg,webp,zip|max:2048',
        ]);

        $seller = auth('api')->user();
        $seller_stores = Store::where('store_seller_id', $seller->id)->pluck('id');
        $ticket = Ticket::find($request->ticket_id);
        if (!$seller_stores->contains($ticket->store_id)) {
            return response()->json([
                'message' => __('messages.ticket_does_not_belongs_to_this_store'),
            ], 422);
        }

        $filename = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = 'seller/support-ticket/' . now()->timestamp . '_' . str_replace(['@', '.'], '_', $seller->email) . '_' . $file->getClientOriginalName();
            Storage::disk('import')->put($filename, file_get_contents($file->getRealPath()));
        }
        $messageDetails = [
            'ticket_id' => $validatedData['ticket_id'],
            'sender_id' => $request->store_id,
            'sender_role' => 'store_level',
            'message' => $validatedData['message'],
            'file' => $filename,
        ];
        $message = $this->ticketRepo->addMessage($messageDetails);
        Ticket::where('id', $validatedData['ticket_id'])->update(['updated_at' => now()]);
        return response()->json([
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

    public function getTicketMessages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_id' => 'required|integer|exists:stores,id',
            'ticket_id' => 'required|integer|exists:tickets,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => $validator->errors()
            ]);
        }
        $seller = auth('api')->user();
        $seller_stores = Store::where('store_seller_id', $seller->id)->pluck('id');
        $ticket = Ticket::find($request->ticket_id);
        if (!$seller_stores->contains($ticket->store_id)) {
            return response()->json([
                'message' => __('messages.ticket_does_not_belongs_to_this_store'),
            ], 422);
        }
        $ticket_messages = TicketMessage::where($ticket->id)->where('')->get();

        $ticketMessages = $this->ticketRepo->getTicketMessages($request->ticket_id);
        return response()->json(SupportTicketMessageResource::collection($ticketMessages));
    }
}
