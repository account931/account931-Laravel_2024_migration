<?php
//Factory trait has been introduced in Laravel v8 so can not use it 
namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Owner;
use Faker\Generator as Faker;
use App\Enums\LocationType; //Enums is a new syntax introduced in PHP 8.1, and not supported in older PHP versions.
//use Illuminate\Database\Eloquent\Factories\Factory; Factory trait has been introduced in Laravel v8 so can not use it 

$factory->define(\App\Models\Owner::class, function (Faker $faker) { 
    return [
        //
		'first_name' => $faker->firstName('male'|'female'),
		'last_name'  => $faker->lastName,
		'phone'      => $faker->numerify('+45########'),
        'email'      => $faker->unique()->safeEmail,
		'confirmed'  => $faker->boolean(),
		//'location'   => $faker()->randomElement(LocationType::cases()), //Enums is a new syntax introduced in PHP 8.1, and not supported in older PHP versions.
		'location'   => $faker->randomElement(['UA', 'EU']),
		//'email_verified_at' => now(),
		//'remember_token' => Str::random(10),

    ];
});
