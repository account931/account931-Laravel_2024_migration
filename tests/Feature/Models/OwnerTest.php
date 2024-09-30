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
       
    }
	
	
}
