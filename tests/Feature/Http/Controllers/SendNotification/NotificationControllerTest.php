<?php

/*
Tests for 
Validation:
Required fields (message, users)
message length
Invalid user IDs
Notification dispatch:
The correct users are notified
The correct message is passed
Redirect and session flash message
*/
namespace Tests\Feature\Http\Controllers\SendNotification;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Owner;
use App\Models\Venue;
use App\User;
use App\Models\Equipment;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\DatabaseTransactions;  //trait to clear your table after every test
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
//use Illuminate\Testing\Fluent\AssertableJson; //in Laravel < 6 only
use App\Notifications\SendMyNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationControllerTest extends TestCase
{
	use RefreshDatabase; //clear your table after every test //CHANGE!!!!!
	
	 /** @test */
    public function index_displays_users_and_notifications()
    {
        // Arrange: create a user and some notifications
        //$user = User::factory()->create();
		$user = factory(\App\User::class)->create();
        $this->actingAs($user);

        // Optional: Seed some users for the view
        //User::factory()->count(3)->create();
		factory(\App\User::class, 3)->create();

        // Bypass policy or mock it
		/*
        Gate::shouldReceive('authorize')
            ->with('index', \App\Models\Owner::class)
            ->andReturn(true);
			*/

        // Act: call the route
        $response = $this->get(route('send-notification'));

        // Assert: correct view and data
        $response->assertStatus(200);
        $response->assertViewIs('send-notification.index');
        $response->assertViewHasAll([
            'users',
            'currentUserNotifications',
        ]);
    }
	
	
	/** @test */
    public function it_validates_the_request_data()
    {
        $user = factory(\App\User::class)->create();
        $this->actingAs($user);

        $response = $this->post(route('send-notif'), [
            'message' => '',
            'users' => []
        ]);

        $response->assertSessionHasErrors(['message', 'users']);
    }

	
	
	/** @test */
    public function it_sends_notifications_to_selected_users()
    {
        // Mock the notification sending
        Notification::fake(); // Fakes notifications to prevent actual sending
        
        // Mock Mail sending
        Mail::fake(); // Fakes mail sending to prevent actual sending


        $sender = factory(\App\User::class)->create();
        $this->actingAs($sender);

        $recipients = factory(\App\User::class, 2)->create();;

        $recipientIds = $recipients->pluck('id')->toArray();

        $response = $this->post(route('send-notif'), [
            'message' => 'Test message',
            'users' => $recipientIds
        ]);

        // Assert notifications were sent
        foreach ($recipients as $recipient) {
            Notification::assertSentTo(
                $recipient,
                SendMyNotification::class,
                function ($notification, $channels) use ($recipient) {
                    return $notification->user->id === $recipient->id &&
                           $notification->message === 'Test message';
                }
            );
        }

		
		//Assert: Validate that mail was queued
		$user1 = $recipients->first();
		$user2 = $recipients->skip(1)->first();
		
        Mail::assertQueued(\App\Mail\WelcomeEmail::class, function ($mail) use ($user1) {
            return $mail->hasTo($user1->email);
        });

        Mail::assertQueued(\App\Mail\WelcomeEmail::class, function ($mail) use ($user2) {
            return $mail->hasTo($user2->email);
        });
        
		
		$response->assertRedirect(); // Check if it redirects
        $response->assertSessionHas('flashSuccess');
		 // Assert: Check the redirect response (flash message)
        $response->assertSessionHas('flashSuccess', 'Your DB + email notifications & Mail Facade letter was sent successfully to users ' . $recipients->pluck('name'));
		
    }
	
	

    /** @test */
    public function it_rejects_invalid_user_ids()
    {
        $user = factory(\App\User::class)->create();
        $this->actingAs($user);

        $invalidUserId = 999999999999; // does not exist

        $response = $this->post(route('send-notif'), [
            'message' => 'Hello!',
            'users' => [$invalidUserId]
        ]);

        $response->assertSessionHasErrors(['users.0']);
    }

}
