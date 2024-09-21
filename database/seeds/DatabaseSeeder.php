<?php

use Illuminate\Database\Seeder;
use App\Models\Owner;
use Database\Seeds\Subfolder\OwnerSeeder;
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
		    OwnerSeeder::class,  //fill DB table {owners} with data
		]); 
		
		 Cache::flush();
    }
}
