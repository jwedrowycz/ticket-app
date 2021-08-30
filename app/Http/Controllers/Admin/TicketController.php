<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Models\Priority;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\StateChanged;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function pursue(Ticket $ticket)
    {
        $ticket->update(['status_id' => 2, 'updated_by' => auth()->id()]);
        User::find($ticket->user_id)->notify(new StateChanged($ticket, 'Twoje zgłoszenie '. $ticket->title .' jest w trakcie realizacji.'));
        return response()->json($ticket, 201);
    }

    public function complete(Ticket $ticket)
    {
        $ticket->update(['status_id' => 3, 'updated_by' => auth()->id()]);
        User::find($ticket->user_id)->notify(new StateChanged($ticket, 'Twoje zgłoszenie '. $ticket->title .' jest zakończone.'));
        return response()->json($ticket, 201);
    }
}
