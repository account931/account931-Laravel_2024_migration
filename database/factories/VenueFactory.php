<?php
//Factory trait has been introduced in Laravel v8 so can not use it 
namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Owner;
use Faker\Generator as Faker;
use App\Enums\LocationType; //Enums is a new syntax introduced in PHP 8.1, and not supported in older PHP versions.
//use Illuminate\Database\Eloquent\Factories\Factory; Factory trait has been introduced in Laravel v8 so can not use it 

$factory->define(\App\Models\Venue::class, function (Faker $faker) { 
    return [
        //
		'venue_name' => $faker->company, //Str::random(10),
		'address'    => $faker->address,//$faker->lastName,
		'active'     => $faker->boolean(),
		'owner_id'   => Owner::inRandomOrder()->first()->id //Owner::factory()  //assign BelongsTo
		//'email_verified_at' => now(),

    ];
});
