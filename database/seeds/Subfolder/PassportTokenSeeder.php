<?php

namespace Database\Seeds\Subfolder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class PassportTokenSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {		
		//Generate Passport personal token, Passport work will fail without it as {->createToken} will fail. This personal token is required to generate user tokens. Normally, you can also create it one time in console manually => php artisan passport:client --personal 
		$parameters = [
            '--personal' => true,
            '--name' => 'Central Panel Personal Access Client', // You can customize the client name here
        ];
        Artisan::call('passport:client', $parameters);
		//End Generate Passport personal token
    
    }
}
