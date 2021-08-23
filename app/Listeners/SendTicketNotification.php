<?php

namespace App\Listeners;

use App\Events\TicketAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTicketNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TicketAdded  $event
     * @return void
     */
    public function handle(TicketAdded $event)
    {
        //
    }
}
