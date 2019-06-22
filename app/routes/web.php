<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get( '/', function () {
	return view( 'welcome' );
} );


if (env('APP_DEBUG')) {
    \DB::listen(function ($sql) {
        global $queryCount, $requestID;
        if (!isset($requestID)) {
            $requestID = uniqid();
            $queryCount = 0;
        }

        \Log::info($sql->sql);
        \Log::info('Request '.$requestID.', Query: '.++$queryCount.' Time: '.$sql->time);
    });
}
