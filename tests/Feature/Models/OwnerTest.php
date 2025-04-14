<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Owner;
use App\Models\Venue;
use App\Models\Equipment;
use Illuminate\Foundation\Testing\DatabaseTransactions;  //trait to clear your table after every test


class OwnerTest extends TestCase
{
	use DatabaseTransactions; //clear your table after every test
	
    /**
     * Test "owner", "venue", "equipment".  //split to differen
     *
     * @return void
     */
    public function testOwnerModel()
    {
		//DB::statement('SET FOREIGN_KEY_CHECKS=0');       //way to set auto increment back to 1 before seeding a table (instead of ->delete())
        //DB::table('owners')->truncate(); //way to set auto increment back to 1 before seeding a table
		//DB::table('venues')->truncate(); //way to set auto increment back to 1 before seeding a table
		//DB::table('equipments')->truncate(); //way to set auto increment back to 1 before seeding a table
		
		$ownersQuantity = 12;
		
		$result = factory(\App\Models\Owner::class, 12)->create()->each(function ($owner){
				
			//create hasMany relation (Venues to Owners) ->has() is not supported in L6
			 factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){
										
			    //create Many to Many relation (pivot)(Equipments to Venues) 
                $equipments = factory(\App\Models\Equipment::class, 2)->create();
				//$venue->equipments()->saveMany($equipments);
				$venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship
					
			});
				
		});
		
		//test//dd(Owner::count());
        $this->assertCount(12,  Owner::all());
        $this->assertCount(24,  Venue::all());
        $this->assertCount(48,  Equipment::all());		
        //$this->assertEquals(3, 3);	

	    // Since arrow function is available from PHP 7.4 only, we test types manuualy as  we cannot use => $response->assertJson(fn ($json) =>  $json->whereType('data.id', 'integer')->whereType('data.name', 'string') 
        $this->assertIsInt($result->first()->id);
        $this->assertIsString($result->first()->first_name);
        $this->assertIsObject($result->first()->venues());  //assertIsArray
	    $this->assertIsString($result->first()->venues->first()->venue_name);
		$this->assertIsString($result->first()->venues->first()->equipments->first()->trademark_name);		
    }
	
	// Example of testing a method that interacts with a database or external system
    public function testCreateOwner()
    {
        // Create a mock or a real owner object
        $owner = new Owner();
        $owner->create(['first_name' => 'Dima', 'last_name' => 'D', 'email' => 'dima@example.com', 'phone' => '+380975545566', 'location' => 'EUR']);

        // Assertions
        $this->assertDatabaseHas('owners', ['first_name' => 'Dima', 'email' => 'dima@example.com']);
		
		//v2
		$result = factory(\App\Models\Owner::class, 1)->create();
		//dd($result->first()->first_name);
        $this->assertDatabaseHas('owners', ['first_name' => $result->first()->getOriginal('first_name'), 'email' => $result->first()->email]); ////ignore accessor
    }
	
}
