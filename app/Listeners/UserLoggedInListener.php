<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Helpers\TextSave; 

class UserLoggedInListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

  /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle($event)
    { 
	    
        //
		// Access the logged-in user via the $event->user
        $user = $event->user; 
		
		// Example action: log the user login, You can perform any other action here, such as sending an email, updating a record, etc.
        //\Log::info('User logged in: ' . $user->email);
		
		//TextSave::saveUserLoginToTextFile($user); //saves text file to /public/text //DISABLED AS breaks tests with 'Response status code [500] is not a redirect status code.'
		
		
		
	


       
		
    }
	
	
}
