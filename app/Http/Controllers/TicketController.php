<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function store(CreateTicketRequest $request)
    {
        $ticket = Ticket::create([
            'user_id' => Auth::user()->id,
            'event_id' => $request->event_id,
            'slots' => $request->slot
        ]);

        abort_if(!$ticket, CODE_BAD_REQUEST, 'Unable to create ticket. Please try again');

        return JSON(CODE_SUCCESS, "Ticket has been booked successfully.", new TicketResource($ticket));
    }
}
