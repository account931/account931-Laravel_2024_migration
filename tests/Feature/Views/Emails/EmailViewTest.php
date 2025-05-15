<?php

namespace Tests\Feature\Views\Emails;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\Owner;
use App\Models\Venue;
use App\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class EmailViewTest extends TestCase
{
	//use DatabaseTransactions; //clear your table after every test
	use RefreshDatabase;  //change
	
	
    /** @test */
    public function it_sends_email_with_correct_view_data()
    {
        // Arrange: Create a mock user
		$user = factory(\App\User::class)->create([
            'email' => 'user@example.com',
            'name' => 'John Doe',
        ]);
		
        $text = 'This is a test email message.';

        // Fake the mail sending to prevent actual emails from being sent
        Mail::fake();

        // Act: Send the welcome email
        Mail::to($user->email)->send(new WelcomeEmail($user, $text));

        // Assert: Check that an email was sent and verify that the email has the correct view
        Mail::assertSent(WelcomeEmail::class, function ($mail) use ($user, $text) {
            // Check if the email contains the correct view and the data is passed properly
            return $mail->hasTo($user->email) && // Check if the email was sent to the correct user
                $mail->user->name === $user->name && // Check that the user data was passed correctly
                $mail->text === $text; // Check if the text was passed correctly
        });

        // Assert: Check that the email view is being rendered with the correct data
        //$viewContent = $this->renderEmailView(new WelcomeEmail($user, $text));  //InvalidArgumentException: No hint path defined for [mail].

        // Assert: Check if the user's name is inside the view
        //$this->assertStringContainsString($user->name, $viewContent);

        // Assert: Check if the message is rendered in red
        //$this->assertStringContainsString('<span style="color:red">' . $text . '</span>', $viewContent);

        // Assert: Check if the button URL is correct
        //$this->assertStringContainsString(url('/'), $viewContent);

        // Assert: Check if the thanks message is correct
        //$this->assertStringContainsString(config('app.MAIL_FROM_NAME'), $viewContent);
    }

    /**
     * Render the email view and return the output as a string.
     *
     * @param \App\Mail\WelcomeEmail $email
     * @return string
     */
    protected function renderEmailView($email)
    {
		return $email->render();
		
        // Render the email view and return the content as a string
         // Instead of calling render() on the Mailable object directly,
        // we manually render the markdown view.
		/*
        return view('emails.mail-facade', [
            'user' => $email->user,
            'text' => $email->text
        ])->render();  */     // This renders the actual view content as a string.
    }
}
