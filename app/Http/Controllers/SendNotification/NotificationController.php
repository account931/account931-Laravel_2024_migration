<?php
//

namespace App\Http\Controllers\SendNotification;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller; //to place controller in subfolder
use App\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use App\Notifications\SendMyNotification;

class NotificationController extends  Controller
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	 public function __construct(){
	    //$this->middleware('auth'); //logged users only	
	}
	
	/**
     * 
     * @return \Illuminate\View\View
     */
    public function index() 
    {   
	    //using Policy. There 3 possible ways
	    //$this->authorize('index', Owner::class); //must have, Policy check (403 if fails)

		$users = User::all();
		$currentUserNotifications = auth()->user()->notifications() ->paginate(10); //get currnet user DB notifications
		
        return view('send-notification.index')->with(compact('users', 'currentUserNotifications'));
    }
	
	/**
     * Handles notification form $_POST request, sends DB & emal notification + sends usual mail
     * @return \Illuminate\Http\RedirectResponse Redirects back to the notification creation page
     */
	public function handleNotificationAndSend(Request $request) 
    {  
	//dd($request->input()['users']);

	    $request->validate([
           'message' => 'required|min:3',
		   'users'   => 'required||array', 
		   'users.*' => 'in:' . implode(',', User::pluck('id')->toArray()),  //returns '1,2', // Each tag must be in the list
        ]);

	    $data = $request->input();
	    //dd($data['users']);
		
		 //$user = User::find(1);  // Retrieve the user to send the notification to
		 $users = User::find($data['users']);

		 foreach($users as $user){
			 
            // Send notification with a message (goes both to DB & email)
             $user->notify(new SendMyNotification($user,  $data['message'] ));
			 
			 //send usual email (just to test)
			 //
		 }
		 
		 return redirect()->back()->with('flashSuccess','Your database and email notification was sent successfully to user ' . $users->pluck('name'));
	}	
	
	
}
