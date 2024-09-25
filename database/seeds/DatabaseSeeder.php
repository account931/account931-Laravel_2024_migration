<?php

use Illuminate\Database\Seeder;
use App\Models\Owner;
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
		$this->call([
		    OwnerSeeder::class,  //fill DB table {owners} with data (also include seeding table {venues} vis hasMany)
			//VenueSeeder::class,  //fill DB table {venues} with data
		]); 
		
	    $this->command->info('Seedering action was successful!');
		
		Cache::flush();
    }
}
