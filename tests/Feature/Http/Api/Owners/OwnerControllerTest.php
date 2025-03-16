<?php

namespace Tests\Feature\Http\Api\Owners;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Owner;
use App\Models\Venue;
use App\User;
use App\Models\Equipment;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\DatabaseTransactions;  //trait to clear your table after every test
use Illuminate\Support\Facades\Artisan;
//use Illuminate\Testing\Fluent\AssertableJson; //in Laravel < 6 only

class OwnerControllerTest extends TestCase
{
	use DatabaseTransactions; //clear your table after every test
	
	/**
	* Test for GET all 'api/owners'
	* api response structure {"data":[{"id":1,"first_name":"Petro","last_name":"Bins", ,"venues":[ {"id":1,"venue_name":"Some1","address":"Some1","equipments":[{"id":1,"trademark_name":"tname1","model_name":"name1"}, {"id":1,"venue_name":"Some1","address":"Some1","equipments":[{"id":2,"trademark_name":"tname2","model_name":"name3"} ]}, ...'owners_count': 12, 'owners_confirmed_count': 4], 
	*/
	public function testOwnerApi()
    {
		//DB::statement('SET FOREIGN_KEY_CHECKS=0');       //way to set auto increment back to 1 before seeding a table (instead of ->delete())
        //DB::table('owners')->truncate(); //way to set auto increment back to 1 before seeding a table
		//DB::table('venues')->truncate(); //way to set auto increment back to 1 before seeding a table
		//DB::table('equipments')->truncate(); //way to set auto increment back to 1 before seeding a table
		
		$ownersQuantity = 12;
		
		$result = factory(\App\Models\Owner::class, 12)->create(['first_name' => 'Petro', 'confirmed' => 1 ])->each(function ($owner){
				
			//create hasMany relation (Venues attached to Owners) ->has() is not supported in L6
			 factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){
										
			    //create Many to Many relation (pivot)(Equipments attached to Venues) 
                $equipments = factory(\App\Models\Equipment::class, 2)->create();
				//$venue->equipments()->saveMany($equipments);
				$venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship
					
			});
				
		});
		
		
		$response = $this->get('/api/owners');
        $response->assertStatus(200);
		//var_dump($response);
		
		//dd($this->getJson(route('api/owners')));
		
		$this->getJson(route('api/owners'))
            ->assertOk()
            ->assertJsonCount(12, 'data')

		    ->assertJsonFragment([
		        'first_name' => 'Petro', //set in this file in  factory(\App\Models\Owner::class, 12)->create(['first_name' => 'Petro', 'confirmed' => 1 ])
		        'last_name'  => $result->first()->last_name,
				'first_name' => $result->first()->getOriginal('first_name'), //ignore accessor
				'venue_name'    => $result->first()->venues[0]['venue_name'], 
			])
				
		 ->assertJsonStructure([    //same as checking with has(): ->assertJson(function ($json) {$json->has('data') ->has('data.id')
		    'data' => [
			    '*' => [ //* to specify an array
			        'id',
					'first_name',
			        'last_name',
					'confirmed',
					
					'venues' => [  //venues: ['venue_name', 'address', 'equipments':[]]
					    '*' => [   // * means each array, e.g 'venues' is an array
					       'venue_name',
						   'address',
						   'active',
						   
						   'equipments' => [
						       '*' => [
							       'trademark_name',
								   'model_name',
								]	   
						   ]
						   
					    ]
					],
					//'venues.equipments', 
			    ]
			],
			'owners_count'           => 'owners_count',
			'owners_confirmed_count' => 'owners_confirmed_count'
			
			
		])
		
		->assertJson([
		    'owners_count'           => 12,
			'owners_confirmed_count' => 12 //set in Factory in this file in factory(\App\Models\Owner::class, 12)->create(['first_name' => 'Petro', 'confirmed' => 1 ])
		]);
		
		// Since arrow function is available from PHP 7.4 only, we test types manuualy as  we cannot use => $response->assertJson(fn ($json) =>  $json->whereType('data.id', 'integer')->whereType('data.name', 'string') 
		$this->assertIsInt($response['data'][0]['id']);
		$this->assertIsString($response['data'][0]['first_name']);
        $this->assertIsArray($response['data'][0]['venues']);
	    $this->assertIsString($response['data'][0]['venues'][0]['venue_name']);
		$this->assertIsString($response['data'][0]['venues'][0]['equipments'][0]['trademark_name']);
		

		//not working with error 'assertJson() must be of the type array, object given'
		/*
		$response->assertJson( function (AssertableJson $json) {
            $json->has('data.0', function (AssertableJson $jsonn){ 
			        $jsonn->whereAllType([
					    'first_name' => 'string'
					]);
				})->etc();
			});
			*/
		
		/*
        ->assertJson(
            fn (AssertableJson $json) => $json
                ->has(
                    'data.0',
                    fn (AssertableJson $json) => $json
                        ->whereType('uuid', 'string')
                        ->whereType('external_id', 'string')
                        ->whereType('type', 'string')
                        ->whereType('type_object', 'array')
                        ->whereType('name', 'string')
                )
                ->whereType('links', 'array')
                ->whereType('meta', 'array')
            );
        });
		*/
	}
	
    /**
	* Test for GET one owner 'api/owner/{id}'
	* api response structure {"data":{"id":1,"first_name":"Hettie","last_name":"Osinski","confirmed":0,"venues":[{"id":1,"venue_name":"Spencer-Raynor","address":"35238 Paige Meado","active":1,"equipments":[{"id":1,"trademark_name":"Technics","model_name":"SL-1200"},{"id":2,"trademark_name":"Technics","model_name":"SL-1200"}],"status":"success"},{"id":2,"venue_name":"Ziemann Inc","address":"359 Crawford Mews","active":1,"equipments":[{"id":3,"trademark_name":"Numark","model_name":"500"},{"id":4,"trademark_name":"Pioneer","model_name":"500"}],"status":"success"}],"status":"success"}} 
	*/
	public function testShow()
    {   
		$ownersQuantity = 1;
		
		$result = factory(\App\Models\Owner::class, $ownersQuantity)->create(['first_name' => 'Petro', 'confirmed' => 1 ])->each(function ($owner){
				
		    //create hasMany relation (Venues to Owners) ->has() is not supported in L6
	        factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){
										
	            //create Many to Many relation (pivot)(Equipments to Venues) 
                $equipments = factory(\App\Models\Equipment::class, 2)->create();
		        //$venue->equipments()->saveMany($equipments);
		        $venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship			
		    });
				
		});
		
		//dd($result);
		//$this->assertTrue(true);
		$owner = Owner::first();
	    //dd($owner);
		
		$response = $this->get('api/owner/' . $owner->id);
        $response->assertStatus(200)
		        ->assertJsonCount(2, 'data.venues')
				->assertJsonCount(2, 'data.venues.0.equipments') //1st array of  => venues[0].equipments
				->assertJsonCount(2, 'data.venues.1.equipments')
				
			    ->assertJsonFragment([
		            'first_name'    => 'Petro', //set in this file in  factory(\App\Models\Owner::class, 12)->create(['first_name' => 'Petro', 'confirmed' => 1 ])
		            'last_name'     => $result->first()->last_name,
					'first_name'    => $result->first()->getOriginal('first_name'), //ignore accessor
					'venue_name'    => $result->first()->venues[0]['venue_name'], 
				])
				
                ->assertJsonStructure([   //same as checking with has(): ->assertJson(function ($json) {$json->has('data') ->has('data.id')       
		            'data' => [
			            'id',
					    'first_name',
			            'last_name',
					    'confirmed',
						'venues' => [  //venues: ['venue_name', 'address', 'equipments':[]]
					        '*' => [
					            'venue_name',
						        'address',
								 'active',
						   
						        'equipments' => [
						           '*' => [
							           'trademark_name',
								       'model_name',
								    ]	   
						        ]
						   
						    ]
						],	
						'status'
					],
					//'status'  // why failing
				]);
				
				/*
				->assertJson([
		           'data'  => 'success',
		        ]);
				*/
			
				
				
				
				// Since arrow function is available from PHP 7.4 only, we test types manuualy as  we cannot use => $response->assertJson(fn ($json) =>  $json->whereType('data.id', 'integer')->whereType('data.name', 'string') 
				$this->assertIsInt($response['data']['id']);
				$this->assertIsString($response['data']['first_name']);
                $this->assertIsArray($response['data']['venues']);
				$this->assertIsString($response['data']['venues'][0]['venue_name']);
				$this->assertIsString($response['data']['venues'][0]['equipments'][0]['trademark_name']);
				
				/*
				->assertJson([
                    'status' => 'success',
                ]); 
				
				*/
				
				//->whereType('first_name', 'string|null');
				//->assertIsInt('data.0.id'); 
		
				/*
				 ->assertExactJson([
                'status' => true,
            ]); 
			*/
		
	}
	
	

	//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!	
	/**
	* Test for /Post to create one owner 'api/owner/create'
	* api response structure:
	*/
	public function testStore()
    { 
		$this->withoutExceptionHandling(); //to see errors

		//create 2 venues with attached equipments
		$venues = factory(\App\Models\Venue::class, 2)->create()->each(function ($venue){
										
			    //create Many to Many relation (pivot)(Equipments to Venues) 
                $equipments = factory(\App\Models\Equipment::class, 2)->create();
				//$venue->equipments()->saveMany($equipments);
				$venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship
					
		});
		
		//dd($venues->first()->equipments);
		
	    // Make the login request with invalid credentials
        //$response = $this->postJson('/owner/create', [
		$response = $this->json('post', 'api/owner/create', [
            'first_name'    => 'Dimaa',
            'last_name'     => 'Dima',
            'location'      => 'EUR',
			'email'         => 'dimqqq@gmail.com',  //email is unique on create only, not on update
			'phone'         => '+380975654455',	
			'owner_venue'   => $venues->pluck('id'), //array of venues ids to be  attached to owner (later in Api Controller)
        ]);

        // Assert the response status is 401 (unauthorized)
        //$response->assertStatus(401);
        //dd($response);
		
		$response->assertStatus(200)
		    ->assertJsonCount(2, 'owner.venues')
			->assertJsonCount(2, 'owner.venues.0.equipments') //1st array of  => venues[0].equipments
			->assertJsonCount(2, 'owner.venues.1.equipments')
				
			->assertJsonFragment([
		            'first_name'    => 'Dimaa', //ignore accessor 
		            'last_name'     => 'Dima',
					'venue_name'    => $venues->first()->venue_name, //$response['owner']['venues'][0]['venue_name'], 
				])
				
                ->assertJsonStructure([   //same as checking with has(): ->assertJson(function ($json) {$json->has('data') ->has('data.id')       
		            'owner' => [
			            'id',
					    'first_name',
			            'last_name',
					    'confirmed',
						'venues' => [  //venues: ['venue_name', 'address', 'equipments':[]]
					        '*' => [
					            'venue_name',
						        'address',
								 'active',
						   
						        'equipments' => [
						           '*' => [
							           'trademark_name',
								       'model_name',
								    ]	   
						        ]
						   
						    ]
						],	
						'status'
					],
					//'message' => 'Created successfully'  //why failing???
				]);
	}
	
	
	
	
	
	
	
	
	
	
	
	//test owner update
	//test owner delete











	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	/**
	* Test for GET protected endpoint 'api/owners/quantity' (Passport). Duplicate is in Tests\Feature\Passport; May delete this test later
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
	* Test for GET protected endpoint 'api/owners/quantity' (Passport). Duplicate is in Tests\Feature\Passport; May delete this test later
	* api response structure 
	*/
	public function testShouldNotSeeQuantityWithoutPassport()
    {
		
		$response = $this->get('/api/owners/quantity'); //dd($response);
        $response->assertStatus(401); // should get 'UnAuthenticated' without Passport token
	}		
		
		
	
	
}
