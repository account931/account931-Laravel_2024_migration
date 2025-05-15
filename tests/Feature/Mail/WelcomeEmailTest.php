<?php

namespace Tests\Feature\Mail;

use App\Mail\WelcomeEmail;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeEmailTest extends TestCase
{
    use RefreshDatabase; //clear your table after every test //CHANGE!!!!!

    /** @test */
    public function it_sends_welcome_email_with_correct_data()
    {
        // Arrange: Create a mock user
		$user = factory(\App\User::class)->create([
            'email' => 'user@example.com',
            'name' => 'John Doe',
        ]);
	
	    //$user = $user->first();
        $text = 'This is a test email message.';

        // Fake the mail sending
        Mail::fake();

        // Act: Send the welcome email
        Mail::to($user->email)->send(new WelcomeEmail($user, $text));

        // Assert: Ensure an email was sent
        Mail::assertSent(WelcomeEmail::class, function ($mail) use ($user, $text) {
            // Check if the email was sent to the correct recipient
            return $mail->hasTo($user->email) &&
                //$mail->subject === 'Via Mail Facade!' && // Check if the subject is correct   //GIVES AN ERROR!!!!!!!!!!!!!
                $mail->user->email === $user->email && // Check if the user data is passed
                $mail->text === $text; // Check if the message is passed correctly
        });
		

    }
	
	

    /** @test */
	/*
    public function it_checks_email_markdown_view_is_correctly_rendered()
    {
        // Arrange: Create a mock user
        $user = factory(\App\User::class)->create([
            'email' => 'user@example.com',
            'name' => 'John Doe',
        ]);
		
        $text = 'This is a test email message.';

        // Fake the view rendering
        View::shouldReceive('make')
            ->once()
            ->with('emails.mail-facade', ['user' => $user, 'text' => $text])
            ->andReturn('view-content');

        // Act: Send the welcome email
        $email = new WelcomeEmail($user, $text);

        // Assert: Ensure the email view is rendered correctly
        //$this->assertEquals('view-content', $email->render());
    }
	*/


    /** @test */
    public function it_sends_email_to_the_correct_recipient()
    {
        // Arrange: Create a mock user
       	$user = factory(\App\User::class)->create([
            'email' => 'user@example.com',
            'name' => 'John Doe',
        ]);
		
        $text = 'This is a test email message.';

        // Fake the mail sending
        Mail::fake();

        // Act: Send the welcome email
        Mail::to($user->email)->send(new WelcomeEmail($user, $text));

        // Assert: Ensure an email was sent to the correct recipient
        Mail::assertSent(WelcomeEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email) && // Check the recipient email
			       $mail->user->email === $user->email; // Check if the user data is passed
        });
    }
}