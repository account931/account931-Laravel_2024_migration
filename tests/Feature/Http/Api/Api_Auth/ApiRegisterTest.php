<?php

//testing REST API Register (via token),  
namespace Tests\Feature\Http\Api\Api_Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;


class ApiRegisterTest extends TestCase
{
	use RefreshDatabase;
	
	public function testUserIsCreatedSuccessfully() {
    
	$this->withoutExceptionHandling(); //to see errors
    //Passport::$hashesClientSecrets = false;
	
    $payload = [
        'name'      => 'Dima', //$faker->name,
        'email'     => 'dima33f@gmail.com', //$faker->unique()->safeEmail,
        'password'  => Hash::make('password'),
    ];
	
	//dd($this->json('post', '/api/register', $payload));
	
	//Generate Passport personal token, tests will fail without it as {->createToken} will fail. This personal token is required to generate user tokens. Normally, out of tests you create it one time in console manually => php artisan passport:client --personal 
	$parameters = [
            '--personal' => true,
            '--name' => 'Central Panel Personal Access Client', // You can customize the client name here
        ];
    Artisan::call('passport:client', $parameters);
    //End Generate Passport personal token
		
	
    $this->json('post', '/api/register', $payload)
         //->assertStatus(Response::HTTP_CREATED)
		 ->assertOk()
         ->assertJsonStructure(
             [
                 'user' => [
                     'name',
                     'email',
					 'updated_at',
					 'created_at',
					 'id'
                 ],
				 'access_token'
             ]
         )
		 ->assertJsonFragment([
		        'name'  => 'Dima',
				'email' => 'dima33f@gmail.com',
		        
			]);
    //$this->assertDatabaseHas('users', $payload);
}
}