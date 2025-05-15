<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\User;

class TextSave 
{

   //public $user;
	
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
		//$this->user     = $user;
    }
	
	 /**
     * Save user login information to a text file.
     *
     * @param \App\User $user
     * @return void
     */
	public static function saveUserLoginToTextFile($user){
		
		$fp = fopen('text/testfile.txt', 'a');  //saves text file to /public/text
		
		// Check if the file was opened successfully
        if ($fp === false) {
            return 'Error opening the file for writing.';
        }
		
        fwrite($fp, "User " . $user->email . " logged "  .Carbon::now()->toDateTimeString() . "\n" );
        fclose($fp);
	}
	
}
