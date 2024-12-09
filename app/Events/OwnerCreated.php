<?php
//defined in Models\Owner => $dispatchesEvents = [event/listener]. Event is bound to Listener in Providers\EventServiceProvider
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Owner;

class OwnerCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
	
	public $owner;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Owner $owner)
    {
        //
		$this->owner = $owner;
    }


}
