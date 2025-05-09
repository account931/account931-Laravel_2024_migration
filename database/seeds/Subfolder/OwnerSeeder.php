<?php

namespace Database\Seeds\Subfolder;

use Illuminate\Database\Seeder;
use App\Models\Owner;
use App\Models\Venue;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;

class OwnerSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {		
	    //DB::table('owners')->delete();  //whether to delete old data
		//DB::statement('SET FOREIGN_KEY_CHECKS=0');       //way to set auto increment back to 1 before seeding a table (instead of ->delete())
        //DB::table('owners')->truncate(); //way to set auto increment back to 1 before seeding a table
		//DB::table('venues')->truncate(); //way to set auto increment back to 1 before seeding a table
		//DB::table('equipments')->truncate(); //way to set auto increment back to 1 before seeding a table
		
        // $this->call(UsersTableSeeder::class);
		///Owner::factory()->count(5)->create(); //Factory trait has been introduced in Laravel v8.
	    //$owners = factory(App\Models\Owner::class, 3)->make();
		factory(\App\Models\Owner::class, 12)
		    //overriding some factory values in 
		    /*->state([
                'email'     => 'dimmm@gmail.com',
                'location'  => 'UA',
             ])*/
			 
		    //sequence is not supported in Laravel 6 (overriding factory values in sequence )
		    /* ->sequence(
                ['confirmed' => 1],
                ['confirmed' => 0]
            ) */
            //->has(factory(\App\Models\Venue::class, 1)) //not supported in Laravel 6??
		    ->create()->each(function ($owner){
				
			    //create hasMany relation (Venues to Owners) ->has() is not supported in L6
			    factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ])->each(function ($venue){
					
					
					//$venue->owner()->associate(1); //not working so far
					
					//create Many to Many relation (pivot)(Equipments to Venues) 
                    $equipments = factory(\App\Models\Equipment::class, 2)->create();
					//$venue->equipments()->saveMany($equipments);
					$venue->equipments()->sync($equipments->pluck('id')); //Eloquent:relationship
					
					
				});
				
			});
    }
}
