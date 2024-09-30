<?php

namespace App\Listeners;

use App\Events\OwnerCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOwnerCreatedNotification
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
     * @param  OwnerCreated  $event
     * @return void
     */
    public function handle(OwnerCreated $event)
    {
        //
		//dd($event->owner->id); //created owner
		$event->owner->forceDelete();
		dd("Event Listener works. Created Owner {$event->owner->id} was deleted at once (App\Events\OwnerCreated <==> App\Listeners\SendOwnerCreatedNotification)");
    }
}
