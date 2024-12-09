<?php

use Illuminate\Database\Seeder;
use App\Models\Owner;
use Database\Seeds\Subfolder\UserSeeder;
use Database\Seeds\Subfolder\OwnerSeeder;
use Database\Seeds\Subfolder\VenueSeeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		Owner::unsetEventDispatcher(); //fix not to fire Events on creating Owner (we have custom Event/Listener on Owner created in console (for test purpose)
		                               //and dont need it to fire in Seeder
		
		$this->call([
		    UserSeeder::class,   //create 1 user
		    OwnerSeeder::class,  //fill DB table {owners} with data (also include seeding table {venues} vis hasMany)
			//VenueSeeder::class,  //fill DB table {venues} with data
		]); 
		
	    $this->command->info('Seedering action was successful!');
		
		Cache::flush();
    }
}
