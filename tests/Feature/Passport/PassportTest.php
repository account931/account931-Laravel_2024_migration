<?php

//duplicate from Tests\Feature\Http\Api\Owners/OwnerControllerTest
namespace Tests\Feature\Passport;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Owner;
use App\Models\Venue;
use App\User;
use App\Models\Equipment;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\DatabaseTransactions;  //trait to clear your table after every test
use Illuminate\Support\Facades\Artisan;

class PassportTest extends TestCase
{
	use DatabaseTransactions; //clear your table after every test

   /**
	* Test for GET protected endpoint 'api/owners/quantity' (Passport)
	* api response structure 
	*/
	public function testShouldSeeQuantityWithPassport()
    {
		$this->withoutExceptionHandling();
		
		$ownersQuantity = 4;
		
		$result = factory(\App\Models\Owner::class, $ownersQuantity)->create(['first_name' => 'Petro', 'confirmed' => 1 ])->each(function ($owner){
				
		    //create hasMany relation (Venues to Owners) ->has() is not supported in L6
	        factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){
										
	            //create Many to Many relation (pivot)(Equipments to Venues) 
                $equipments = factory(\App\Models\Equipment::class, 2)->create();
		        //$venue->equipments()->saveMany($equipments);
		        $venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship			
		    });	
		});
		
		
	    //Generate Passport personal token, tests will fail without it as {->createToken} will fail. This personal token is required to generate user tokens. Normally, out of tests you create it one time in console manually => php artisan passport:client --personal 
		$parameters = [
            '--personal' => true,
            '--name' => 'Central Panel Personal Access Client', // You can customize the client name here
        ];
        Artisan::call('passport:client', $parameters);
		//End Generate Passport personal token
		
		//Passport::actingAs(User::find(1) );
				
		
		$user = factory(\App\User::class, 1)->create(); 
		$this->actingAs(User::first(), 'api');  //otherwise get error: AuthenticationException: Unauthenticated. Sending token in request does not help
		
        $bearerToken = User::first()->createToken('UserToken', ['*'])->accessToken;
		
		$response = $this->get('/api/owners/quantity' //, 
		    //[ 'headers' => [ 'Authorization' => 'Bearer ' . $bearerToken ]]  //may drop this line, as all u need is using => $this->actingAs(User::first(), 'api'); 
			); 
        $response
		    ->assertStatus(200)       // should get 'UnAuthenticated' without Passport token
		    ->assertJsonStructure([   //same as checking with has(): ->assertJson(function ($json) {$json->has('data') ->has('data.id')       
		        'owners quantity',
				'status'
			])
			->assertJsonFragment([
		        'owners quantity' => 4,
				'status'          => 'OK'
			]);
	}
	
		
    /**
	* Test for GET protected endpoint 'api/owners/quantity' (Passport)
	* api response structure 
	*/
	public function testShouldNotSeeQuantityWithoutPassport()
    {
		
		$response = $this->get('/api/owners/quantity'); //dd($response);
        $response->assertStatus(401); // should get 'UnAuthenticated' without Passport token. For now, error response is set in App\Exceptions\Handler
	}		
		
}
