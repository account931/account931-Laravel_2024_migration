<?php

use Illuminate\Database\Seeder;
use App\Models\Owner;
use Database\Seeds\Subfolder\UserSeeder;
use Database\Seeds\Subfolder\OwnerSeeder;
use Database\Seeds\Subfolder\VenueSeeder;
use Database\Seeds\Subfolder\RolesPermissionSeeder;
use Database\Seeds\Subfolder\PassportTokenSeeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		if (App::environment() === 'production') {
            exit('I just stopped you getting fired.');
        }
		
		Owner::unsetEventDispatcher(); //fix not to fire Events on creating Owner (we have custom Event/Listener on Owner created in console (for test purpose)
		                               //and dont need it to fire in Seeder
		
		$this->call([
		    UserSeeder::class,           //create 2 users with venues and equipments
			PassportTokenSeeder::class,  //generate Passport personal token that will used later to generate users token later. Or you will have to run it manually in console => php artisan passport:client --personal
			RolesPermissionSeeder::class,//create Role/permission
		    OwnerSeeder::class,  //fill DB table {owners} with data (also include seeding table {venues} vis hasMany)
			//VenueSeeder::class,  //fill DB table {venues} with data
		]); 
		
	    $this->command->info('Seedering action was successful!');
		
		Cache::flush();
    }
}
