<?php
//this is the test of middleware\ForceJsonRespons, but so far it is not used in routes/api, so we just test if endpoint returns correct headers 'Content-Type', 'application/json'
namespace Tests\Feature\Http\Middleware;

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

class ForceJsonResponseTest extends TestCase
{
	use DatabaseTransactions; //clear your table after every test
	
	/**
     * Test a route that already returns JSON to ensure the middleware doesn't interfere.
     *
     * @return void
     */
    public function test_api_route_returns_json()
    {
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

        // Assert that the response is a JSON response
        $response->assertHeader('Content-Type', 'application/json');

        // Assert the JSON structure of the response
        $response->assertJsonStructure([    //same as checking with has(): ->assertJson(function ($json) {$json->has('data') ->has('data.id')
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
			]
		]);
    }

}
