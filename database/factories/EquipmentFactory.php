<?php
//Factory trait has been introduced in Laravel v8 so can not use it 
namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Equipment;
use Faker\Generator as Faker;
//use Illuminate\Database\Eloquent\Factories\Factory; Factory trait has been introduced in Laravel v8 so can not use it 

$factory->define(\App\Models\Equipment::class, function (Faker $faker) { 
    return [
        //
		'trademark_name' => $faker->randomElement(['Pioneer', 'Vestax', 'Technics', 'Numark']), //$faker->company, //Str::random(10),
		'model_name'     => $faker->randomElement(['SL-1200', '500', 'G-120', 'M-1000']), //$faker->name,    //$faker->lastName,
		'description'    => $faker->sentence(3),
		//'owner_id'   => Owner::inRandomOrder()->first()->id //Owner::factory()  //assign BelongsTo

    ];
});
