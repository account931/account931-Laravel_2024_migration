<?php
/*
Test Goals:
Ensure the notification uses the correct channels (mail and database).
Test the toMail() method returns a proper MailMessage (via Markdown).
Test the toArray() method returns the expected data.
Optionally: Ensure the class handles properties ($user, $message) correctly.
*/

namespace Tests\Feature\Notifications;

use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\MyTestCronJob;
use App\Models\Owner;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;       //trait to clear your table after every test
use App\Notifications\SendMyNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SendMyNotificationTest extends TestCase
{
	use RefreshDatabase;       //trait to clear your table after every test
	
    /** @test */
    public function it_uses_mail_and_database_channels()
    {
        //$user = User::factory()->make();
		$user = factory(\App\User::class)->create();
        $notification = new SendMyNotification($user, 'Test message');

        $channels = $notification->via($user);

        $this->assertContains('mail', $channels);
        $this->assertContains('database', $channels);
    }

    /** @test */
    public function it_returns_proper_mail_message()
    {
        $user = factory(\App\User::class)->create();
        $notification = new SendMyNotification($user, 'Test message');

        $mailMessage = $notification->toMail($user);

        $this->assertInstanceOf(MailMessage::class, $mailMessage);
        $this->assertEquals("Subject for {$user->name}", $mailMessage->subject);
    }

    /** @test */
    public function it_returns_correct_array_for_database()
    {
        $user = factory(\App\User::class)->create();
        $notification = new SendMyNotification($user, 'Test DB message');

        $arrayData = $notification->toArray($user);

        $this->assertArrayHasKey('data', $arrayData);
        $this->assertEquals("Hello {$user->name} Test DB message", $arrayData['data']);
    }
}
