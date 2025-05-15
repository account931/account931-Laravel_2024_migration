<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\OwnerCreated;
use App\Listeners\SendOwnerCreatedNotification;
use App\Listeners\UserLoggedInListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
		
		//my event/listener
		  OwnerCreated::class => [ SendOwnerCreatedNotification::class ],
		
		// register listening to built-in event 'Login'
		\Illuminate\Auth\Events\Login::class => [ UserLoggedInListener::class ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
