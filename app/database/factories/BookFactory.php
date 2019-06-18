<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define( \App\Models\Book::class, function ( Faker $faker ) {
	return [
		'name'         => $faker->sentence,
		'pages'        => $faker->numberBetween( 50, 600 ),
		'ean'          => $faker->ean13,
		'isbn_10'      => $faker->isbn10,
		'isbn_13'      => $faker->isbn13,
		'release_date' => $faker->dateTime,
		'type'         => $faker->randomElement( [ 'HARDCOVER', 'SOFTCOVER', 'EBOOK' ] ),
		'nsfw'         => $faker->boolean,
		'publisher_id' => \App\Models\Publisher::inRandomOrder()->first()->id,
	];
} );
