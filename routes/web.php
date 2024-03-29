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

Route::get( '/', [ 'as' => 'index', 'uses' => 'SiteController@index' ] );

Route::get( '/home', function() {
    return redirect()->route('index');
});

Route::get( '/weather', [ 'as' => 'weather', 'uses' => 'WeatherController@index' ] );
Route::post( '/weather', [ 'uses' => 'WeatherController@index' ] );

Route::group(['prefix' => 'reservations', 'namespace' => 'Frontend\Reservation'], function () {
    Route::get( '/', [ 'as' => 'reservations.create', 'uses' => 'ReservationController@create' ] );
    Route::get( '/wait-list/refresh', [ 'as' => 'reservations.waitlist.refresh', 'uses' => 'ReservationController@refresh' ] );
    Route::get( '/wait-list', [ 'as' => 'reservations.index', 'uses' => 'ReservationController@index' ] );
    Route::post('/', ['as' => 'admin.reservations.store', 'uses' => 'ReservationController@store']);
});

Route::group(['prefix' => 'customers', 'namespace' => 'Frontend\Customer'], function () {
    Route::get( '/', [ 'as' => 'customers.create', 'uses' => 'CustomerController@create' ] );
    Route::post('/', ['as' => 'admin.customers.store', 'uses' => 'CustomerController@store']);
    Route::post('/', function() {
        return redirect()->route('index');
    });
});

//Auth::routes(['verify' => true, 'reister' => false]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
