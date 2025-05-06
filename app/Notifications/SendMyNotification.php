<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMyNotification extends Notification
{
    use Queueable;
    
	public $user;
	public $message;
	
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $message)
    {
        //
		$this->user     = $user;
		$this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];  //send both DB and mail
    }

    /**
	 *  Notification via e-mail
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
		            ->subject("Subject for {$this->user->name}")
					/*
					->greeting('It is greeting')
                    ->line("Hello Dear  {$this->user->name} ")
					->line( $this->message)
                    ->action('Notification Action', url('/'))
					->salutation('Best Regards, Dima'); // acts like a footer
					*/
					
					
					->markdown('emails.notification-mail', [
                       'user' => $notifiable,
                       'invoice' => 'INV123456',
					   'text'    => $this->message,
                    ]);
					
    }

    /**
	 * Database notification
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
           'data' => "Hello {$this->user->name} " . $this->message   //notification text
        ];
    }
}
