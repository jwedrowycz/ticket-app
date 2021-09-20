<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function show(Ticket $ticket, $notify_id = null)
    {
        if(!is_null($notify_id))
        {
            auth()->user()->unreadNotifications->where('id', $notify_id)->markAsRead();
        }
        return view('layouts.ticket', ['ticket' => $ticket]);
    }
}
