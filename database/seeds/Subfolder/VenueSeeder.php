<?php
//not used (went to ->each in  \Database\Seeds\SubfolderOwnerSeeder)!!!!
namespace Database\Seeds\Subfolder;

use Illuminate\Database\Seeder;
use App\Models\Venue;
use Illuminate\Support\Facades\DB;

class VenueSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {		
	    //DB::table('venues')->delete();  //whether to delete old data
		//DB::statement('SET FOREIGN_KEY_CHECKS=0');       //way to set auto increment back to 1 before seeding a table (instead of ->delete())
        //DB::table('venues')->truncate(); //way to set auto increment back to 1 before seeding a table

		factory(\App\Models\Venue::class, 24)->create();
    }
}
