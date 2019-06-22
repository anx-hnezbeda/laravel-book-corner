<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware( 'auth:api' )->get( '/user', function ( Request $request ) {
	return $request->user();
} );

JsonApi::register( 'v1' )->routes( function ( $api ) {
    $api->resource( 'authors' )->relationships( function ( $relations ) {
        $relations->hasMany( 'books' );
    } );
	$api->resource( 'books' )->relationships( function ( $relations ) {
		$relations->hasOne( 'publisher' );
        $relations->hasMany( 'authors' );
        $relations->hasMany( 'categories');
        $relations->hasMany( 'tags' );
        $relations->hasMany( 'users' );
	} )->controller()->routes(function ($books) {
	    $books->get('/stats', function() {
	        return [
	            'books' => \App\Models\Book::count(),
                'available' => \App\Models\Book::doesntHave('users')->count(),
                'taken' => \App\Models\Book::whereHas('users')->count(),
                'categories' => \App\Models\Category::select('id', 'name')->withCount('books')->orderBy('books_count', 'DESC')->get(),
                'tags' => \App\Models\Tag::select('id', 'name')->withCount('books')->orderBy('books_count', 'DESC')->get(),
                'users' => \App\Models\User::select('id', 'name')->withCount('books')->has('books', '>', 0)->orderBy('books_count', 'DESC')->get(),
            ];
        });
    });
	$api->resource( 'bookuser' )->relationships( function ( $relations ) {
		$relations->hasOne( 'book' );
		$relations->hasOne( 'user' );
	} );
	$api->resource( 'categories' )->relationships( function ( $relations ) {
		$relations->hasMany( 'books' );
	} );
	$api->resource( 'publishers' )->relationships( function ( $relations ) {
		$relations->hasMany( 'books' );
	} );
	$api->resource( 'tags' )->relationships( function ( $relations ) {
		$relations->hasMany( 'books' );
	} );
	$api->resource( 'users' )->relationships( function ( $relations ) {
        $relations->hasMany( 'books' );
    } );
} );


