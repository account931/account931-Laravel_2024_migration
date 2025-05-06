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
use Illuminate\Support\Facades\Artisan;
//use Illuminate\Testing\Fluent\AssertableJson; //in Laravel < 6 only
use App\Notifications\SendMyNotification;
use Illuminate\Support\Facades\Notification;


class NotificationControllerTest extends TestCase
{
	use DatabaseTransactions; //clear your table after every test
	
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
        Notification::fake();

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

        $response->assertRedirect();
        $response->assertSessionHas('flashSuccess');
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
