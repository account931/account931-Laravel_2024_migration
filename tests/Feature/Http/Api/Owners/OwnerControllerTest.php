<?php

namespace Tests\Feature\Http\Api\Owners;


use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Owner;
use App\Models\Venue;
use App\Models\Equipment;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\DatabaseTransactions;  //trait to clear your table after every test

class OwnerControllerTest extends TestCase
{
	use DatabaseTransactions; //clear your table after every test
	
	/**
	* Test for GET 'api/owners'
	* api response structure {"data":[{"id":1,"first_name":"Petro","last_name":"Bins"}, ...'owners_count': 12, 'owners_confirmed_count': 4], 
	*/
	public function testOwnerApi()
    {
		//DB::statement('SET FOREIGN_KEY_CHECKS=0');       //way to set auto increment back to 1 before seeding a table (instead of ->delete())
        //DB::table('owners')->truncate(); //way to set auto increment back to 1 before seeding a table
		//DB::table('venues')->truncate(); //way to set auto increment back to 1 before seeding a table
		//DB::table('equipments')->truncate(); //way to set auto increment back to 1 before seeding a table
		
		$ownersQuantity = 12;
		
		$result = factory(\App\Models\Owner::class, 12)->create(['first_name' => 'Petro', 'confirmed' => 1 ])->each(function ($owner){
				
			//create hasMany relation (Venues to Owners) ->has() is not supported in L6
			 factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){
										
			    //create Many to Many relation (pivot)(Equipments to Venues) 
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
		        'first_name' => 'Petro' //set in this file in  factory(\App\Models\Owner::class, 12)->create(['first_name' => 'Petro', 'confirmed' => 1 ])
		    ])
				
		 ->assertJsonStructure([
		    'data' => [
			    '*' => [ //* to specify an array
			        'id',
					'first_name',
			        'last_name',
					'confirmed',
					
					'venues' => [  //venues: ['venue_name', 'address', 'equipments':[]]
					    '*' => [
					       'venue_name',
						   'address',
						   
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
}
