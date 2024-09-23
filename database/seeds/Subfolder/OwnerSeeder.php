<?php

namespace Database\Seeds\Subfolder;

use Illuminate\Database\Seeder;
use App\Models\Owner;

class OwnerSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {		
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
		    ->create();
    }
}
