<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

	public $user;
	public $text;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $text)
    {
        //
		$this->user = $user;
		$this->text = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		//$mailText = 'This is Mail facade';
		
        return $this->subject('Via Mail Facade!')
		         ->markdown('emails.mail-facade');
				 
		//$this->view('emails.mail-facade')->with(compact('user', 'mailText'));
    }
}
