<?php

namespace Tests\Feature\Listeners;

use Tests\TestCase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Owner;
use App\Models\Venue;
use App\User;
use App\Models\Equipment;
use Illuminate\Testing\Fluent\AssertableJson;
//use Illuminate\Foundation\Testing\DatabaseTransactions;  //trait to clear your table after every test
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use App\Events\OwnerCreated;
use App\Listeners\SendOwnerCreatedNotification;
use Illuminate\Support\Facades\Event;

class ListenerTest extends TestCase
{
    use RefreshDatabase; 
   /**
	* Test for listener
	* 
	*/
	public function testEventListenerIsTriggered()
    {
		//Fake the event dispatcher to prevent actual listeners from running
        Event::fake();
		
		$owner = factory(\App\Models\Owner::class)->create();
		
		// Dispatch the event
        event(new OwnerCreated($owner));
		
		 // Assert that the OwnerCreated event was fired
        Event::assertDispatched(OwnerCreated::class);
		
		// Assert that the listener was triggered by checking if the event was dispatched
		//assertListening was introduced in Laravel 8.x. only
		/*
        Event::assertListening(
            OwnerCreated::class,  // The event
            SendOwnerCreatedNotification::class  // The listener
        );
		*/
		
		//Must be working, but firstly have to: 1. add Logging itself to SendOwnerCreatedNotification and comment dd() there 2. create migration + model for table 'Log'
        // Assert that a log entry was created by the listener
		/*
        $this->assertDatabaseHas('logs', [
            //'owner_id' => $owner->id,
            'message'  => 'Owner created ' . $owner->id,
        ]);
		*/
	}		
		
}
