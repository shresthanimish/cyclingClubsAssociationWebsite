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
	Route::get('/', 'App\Http\Controllers\PublicController@index')->name('/');
	Route::get('/about', 'App\Http\Controllers\PublicController@about')->name('about-us');
	Route::get('/clubs', 'App\Http\Controllers\PublicController@clubs')->name('clubs');
	Route::get('/races', 'App\Http\Controllers\PublicController@races')->name('races');
	Route::get('/contact', 'App\Http\Controllers\PublicController@contact')->name('contact-us');
	Route::get('/logout', 'App\Http\Controllers\PublicController@logout');

	// Authentication Routes
	Auth::routes(['verify' => true]);

	Route::group(['middleware' => ['auth', 'verified']], function () {
		// Dashboard route
		Route::get('dashboard', 'App\Http\Controllers\PublicController@dashboard')->name('dashboard');

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

		// Profile routes
		Route::match(['get', 'post'], '/profile/details', 'App\Http\Controllers\ProfileController@details')->name('/profile/details');
		Route::match(['get', 'post'], '/profile/password', 'App\Http\Controllers\ProfileController@password')->name('/profile/password');

		// User routes
		Route::match(['get', 'post'], '/users/index', 'App\Http\Controllers\UsersController@index')->name('/users/index');
		Route::match(['get', 'post'], '/users/create', 'App\Http\Controllers\UsersController@create')->name('/users/create');
		Route::match(['get', 'post'], '/users/update/{id}', 'App\Http\Controllers\UsersController@update')->name('/users/update');
		Route::post('users/delete/{id}', ['as' => 'users/delete', 'App\Http\Controllers\UsersController@delete']);
	});

	/** Fallback Route */
	Route::fallback(function () {
		/** This will check for the 404 view page unders /resources/views/errors/404 route */
		return view('errors.404');
	});


});
