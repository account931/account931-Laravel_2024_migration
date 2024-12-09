<?php
// defined in  Models\Owner => $dispatchesEvents = [] =>  App\Events\OwnerCreated; Event is Bound to Listener in Providers\EventServiceProvider
namespace App\Listeners;

use App\Events\OwnerCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\App;

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
		
        if(App::runningInConsole()){ //run only if triggered in console (routes/console) (php artisan event-listener:start), so not to delete real created owners
		    //dd($event->owner->id); //created owner
		    $event->owner->forceDelete();
		    dd("Event Listener works. Created Owner {$event->owner->id} was deleted at once (App\Events\OwnerCreated <==> App\Listeners\SendOwnerCreatedNotification)");
        } 
	}
}
