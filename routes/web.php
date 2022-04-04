<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['web']], function () {

	// Public Routes
	Route::get('/', 'App\Http\Controllers\PublicController@index');

	// Club routes
	Route::match(['get', 'post'], '/clubs/index', 'App\Http\Controllers\ClubController@index')->name('/clubs/index');
	Route::match(['get', 'post'], '/clubs/create', 'App\Http\Controllers\ClubController@create')->name('/clubs/create');
	Route::match(['get', 'post'], '/clubs/details/{id}', 'App\Http\Controllers\ClubController@details')->name('/clubs/details');
	Route::match(['get', 'post'], '/clubs/delete/{id}', 'App\Http\Controllers\ClubController@delete')->name('/clubs/delete');

	// Rider routes
	Route::match(['get', 'post'], '/riders/index', 'App\Http\Controllers\RiderController@index')->name('/riders/index');
	Route::match(['get', 'post'], '/riders/create', 'App\Http\Controllers\RiderController@create')->name('/riders/create');
	Route::match(['get', 'post'], '/riders/details/{id}', 'App\Http\Controllers\RiderController@details')->name('/riders/details');
	Route::match(['get', 'post'], '/riders/delete/{id}', 'App\Http\Controllers\RiderController@delete')->name('/riders/delete');

	// Race routes
	Route::match(['get', 'post'], '/races/index', 'App\Http\Controllers\RaceController@index')->name('/races/index');
	Route::match(['get', 'post'], '/races/create', 'App\Http\Controllers\RaceController@create')->name('/races/create');
	Route::match(['get', 'post'], '/races/details/{id}', 'App\Http\Controllers\RaceController@details')->name('/races/details');
	Route::match(['get', 'post'], '/races/delete/{id}', 'App\Http\Controllers\RaceController@delete')->name('/races/delete');

	/** Fallback Route */
	Route::fallback(function () {
		/** This will check for the 404 view page unders /resources/views/errors/404 route */
		return view('errors.404');
	});

/*
	// Clear application cache:
	Route::get('/clear-cache', function() {
		$exitCode = Artisan::call('cache:clear');
		return 'Application cache has been cleared';
	});

	//Clear route cache:
	Route::get('/route-cache', function() {
		$exitCode = Artisan::call('route:cache');
		return 'Routes cache has been cleared';
	});

	//Clear config cache:
	Route::get('/config-cache', function() {
		$exitCode = Artisan::call('config:cache');
		return 'Config cache has been cleared';
	});

	// Clear view cache:
	Route::get('/view-clear', function() {
		$exitCode = Artisan::call('view:clear');
		return 'View cache has been cleared';
	});
*/

});
