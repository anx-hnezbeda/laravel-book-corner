<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define( \App\Models\Publisher::class, function ( Faker $faker ) {
	return [
		'name'       => $faker->company,
		'short_name' => $faker->companySuffix,
	];
} );
