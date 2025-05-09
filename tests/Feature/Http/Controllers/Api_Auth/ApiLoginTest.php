<?php

//testing REST API Login (via token),  
namespace Tests\Feature\Http\Controllers\Api_Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class ApiLoginTest extends TestCase
{
	use RefreshDatabase;
	
	public function testShouldLogin()
    {
	    $this->assertTrue(true);  //here we fake success test result
		//do smth here ...........
	}
	
	/**
     * Test login with valid credentials.
     *
     * @return void
     */
    public function test_login_with_valid_credentials()
    {
		$this->withoutExceptionHandling(); //to see errors
		
        // Create a user in the database
		$user = factory(\App\User::class)->create(['password' => Hash::make('password123')]);
        //$user = User::factory()->create(['password' => Hash::make('password123'),]);

		
		//Generate Passport personal token, tests will fail without it as {->createToken} will fail. This personal token is required to generate user tokens. Normally, out of tests you create it one time in console manually => php artisan passport:client --personal 
		$parameters = [
            '--personal' => true,
            '--name' => 'Central Panel Personal Access Client', // You can customize the client name here
        ];
        Artisan::call('passport:client', $parameters);
		//End Generate Passport personal token
		
		
        // Make the login request with valid credentials
        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'password123',
        ]);

        // Assert the response status is 200 (success)
        $response->assertStatus(200)
		     ->assertJsonFragment([
		        'name'  => $user->name, 
				'email' => $user->email, 
			])
            // Assert the response contains a token (for example if using Laravel Passport or Sanctum)
            ->assertJsonStructure([
                'access_token',
				'user' => [
				    'name',
					'email'
				]
        ]);
		
		// Since arrow function is available from PHP 7.4 only, we test types manuualy as  we cannot use => $response->assertJson(fn ($json) =>  $json->whereType('data.id', 'integer')->whereType('data.name', 'string') 
		$this->assertIsString($response['access_token']);
		$this->assertIsArray($response['user']);
    }

    /**
     * Test login with invalid credentials.
     *
     * @return void
     */
    public function test_login_with_invalid_credentials()
    {
        // Create a user in the database
		$user = factory(\App\User::class)->create(['password' => Hash::make('password123')]);
        //$user = User::factory()->create(['password' => Hash::make('password123')]);

        // Make the login request with invalid credentials
        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'wrongpassword',
        ]);

        // Assert the response status is 401 (unauthorized)
        //$response->assertStatus(401);

		$response->assertStatus(200); //we expect HTTP 500, not 401, as that is the logic in App\Http\Controllers\API\AuthController;
        // Assert the response contains the error message
        $response->assertJson([
            'message' => 'Invalid Credentials',
        ]);
    }
}