<?php
namespace App\Listeners;

use Mail;
use App\Events\TicketCreated;

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


use App\Mail\TicketCreated as NewTicketMail;


class TicketCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
    
}

class SendNewTicketMail
    {
      /**
       * Handle the event.
       *
       * @param  TicketCreated  $event
       * @return void
       */
      public function handle(TicketCreated $event)
      {
        if (isset($event->ticket->email)) {
          // send the new ticket notification to user
          Mail::to($event->ticket->email)->send(new NewTicketMail($event->ticket));
        }
      }
    }