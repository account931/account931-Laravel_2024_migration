<?php
//Factory trait has been introduced in Laravel v8 so can not use it 
namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Owner;
use Faker\Generator as Faker;
use App\Enums\LocationType; //Enums is a new syntax introduced in PHP 8.1, and not supported in older PHP versions.
//use Illuminate\Database\Eloquent\Factories\Factory; Factory trait has been introduced in Laravel v8 so can not use it 
use Illuminate\Support\Facades\DB;

$factory->define(\App\Models\Venue::class, function (Faker $faker) { 

   // Mallorca bounding box
    $minLat = 39.1996;
    $maxLat = 39.9578;
    $minLon = 2.3274;
    $maxLon = 3.5315;

    // Generate random latitude and longitude within Mallorca bounding box
    $lat = $faker->randomFloat(6, $minLat, $maxLat);
    $lon = $faker->randomFloat(6, $minLon, $maxLon);


    return [
        //
		'venue_name' => $faker->company, //Str::random(10),
		'address'    => $faker->address,//$faker->lastName,
	    'location'   =>  DB::raw("ST_GeomFromText('POINT(" . $lon . " " . $lat . ")')"),  //Point type (lon, lat), uses getter in Model to return array of coordinates

		//'location'    =>  DB::raw("ST_GeomFromText('POINT(" . $faker->latitude . " " . $faker->longitude . ")')"),  //uses getter in Model to return array of coordinates
	    //'location'    =>  DB::raw("ST_GeomFromText('POINT(2.757999 39.599029)')"),  //uses getter in Model to return array of coordinates

		'active'     => 1, //$faker->boolean(),
		//'owner_id'   => 1, //Owner::inRandomOrder()->first()->id //Owner::factory()  //assign BelongsTo
		//'email_verified_at' => now(),

    ];
});
