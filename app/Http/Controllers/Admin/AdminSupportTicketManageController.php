<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Com\Pagination\PaginationResource;
use App\Http\Resources\Com\SupportTicket\SupportTicketResource;
use App\Interfaces\SupportTicketManageInterface;
use Illuminate\Http\Request;

class AdminSupportTicketManageController extends Controller
{
    public function __construct(protected SupportTicketManageInterface $ticketRepo)
    {

    }
    public function index(Request $request)
    {

        $filters = $request->only([
            'user_id',
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
}
