<?php

namespace Database\Seeds\Subfolder;

use Illuminate\Database\Seeder;
use App\Models\Owner;
use App\Models\Venue;
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
		DB::statement('SET FOREIGN_KEY_CHECKS=0');       //way to set auto increment back to 1 before seeding a table (instead of ->delete())
        DB::table('owners')->truncate(); //way to set auto increment back to 1 before seeding a table
		DB::table('venues')->truncate(); //way to set auto increment back to 1 before seeding a table
		
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
			    //create hasMany relation (Venues) ->has() is not supported in L6
			    factory(\App\Models\Venue::class, 2)->create(['owner_id' => $owner->id ]);	
			});
    }
}
