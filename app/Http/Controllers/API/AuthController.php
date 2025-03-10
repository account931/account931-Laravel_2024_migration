<?php

//Auth controller for REST (via token, not session)
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\App;

class AuthController extends Controller
{
    public function register(Request $request)
    { 
        $validatedData = $request->validate([
            'name'     => 'required|max:55|min:4',
            'email'    => 'email|required|unique:users',
            'password' => 'required|min:3'  //|confirmed
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData); //dd($user); 
		
        $accessToken = $user->createToken('authToken')->accessToken;
		//$accessToken = $user->createToken('authToken');

        return response([ 'user' => $user, 'access_token' => $accessToken ]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

    }
}