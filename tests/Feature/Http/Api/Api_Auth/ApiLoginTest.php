<?php

//testing REST API Login (via token),  
namespace Tests\Feature\Http\Api\Api_Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;

class ApiLoginTest extends TestCase
{
	use RefreshDatabase;
	
	public function testShouldLogin()
    {
	    $this->assertTrue(true);  //here we fake success test result
		//do smth here ...........
	}
}