<?php

namespace Database\Seeds\Subfolder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {		
		DB::statement('SET FOREIGN_KEY_CHECKS=0');       //way to set auto increment back to 1 before seeding a table (instead of ->delete())
        DB::table('users')->truncate(); //way to set auto increment back to 1 before seeding a table
		
		factory(\App\User::class, 1)->create([
		    'name'      => 'Dima',
            'email'     => 'dima@gmail.com',
            'password'	=> Hash::make('password'),		
		]);
		
		factory(\App\User::class, 1)->create([
		    'name'      => 'Olya',
            'email'     => 'olya@gmail.com',
            'password'	=> Hash::make('password'),		
		]);
    
    }
}
