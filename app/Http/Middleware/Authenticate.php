<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
	}
	
    //NB: ENABLING THIS METHOD CAUSES PASSPORT STOP WORKING (protected routes becomes open (even without token)??????	
	// For Api requests. Otherwise API request  without token will be  redirected to html login page instead of json response 'UnAuthenticated'
    /*
	protected function unauthenticated($request, array $guards)
    {
		if ($request->expectsJson()) {
        abort(response()->json(
            [
                'api_status' => '401',
                'message' => 'UnAuthenticated(Passport)',
            ], 401));
        }
    }
	*/
}
