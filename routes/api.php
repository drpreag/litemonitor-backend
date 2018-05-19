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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
    //return $request->user();
//});


Route::group(['middleware' => 'api', 'prefix' => '', 'as' => 'api.'], function() {
	
	// Roles API
	Route::get('roles', 'API\RolesController@index')->name('roles');
	Route::get('role/{id}', 'API\RolesController@show')->name('role');
	Route::put('role', 'API\RolesController@update')->name('role');
	Route::post('role', 'API\RolesController@store')->name('role');
	Route::delete('role/{id}', 'API\RolesController@destroy')->name('role');

	// Users API
	Route::get('users', 'API\UsersController@index')->name('users');
	Route::get('user/{id}', 'API\UsersController@show')->name('user');
	Route::put('user', 'API\UsersController@update')->name('user');
	Route::post('user', 'API\UsersController@store')->name('user');
	Route::delete('user/{id}', 'API\UsersController@destroy')->name('user');

	// Services API
	Route::get('services', 'API\ServicesController@index')->name('services');
	Route::get('service/{id}', 'API\ServicesController@show')->name('service');
	Route::put('service', 'API\ServicesController@update')->name('service');
	Route::post('service', 'API\ServicesController@store')->name('service');
	Route::delete('service/{id}', 'API\ServicesController@destroy')->name('service');

	Route::get('service-stats', 'API\ServicesController@serviceStats')->name('servicestats');
	Route::get('service/{id}/observations', 'API\ServicesController@getObservations')->name('getobservations');	

	// Hosts API
	Route::get('hosts', 'API\HostsController@index')->name('hosts');
	Route::get('host/{id}', 'API\HostsController@show')->name('host');
	Route::put('host', 'API\HostsController@update')->name('host');
	Route::post('host', 'API\HostsController@store')->name('host');
	Route::delete('host/{id}', 'API\HostsController@destroy')->name('host');

	Route::get('host-stats', 'API\HostsController@hostStats')->name('hoststats');
	Route::get('host/{id}/services', 'API\HostsController@getServices')->name('hostservices');	

	// Flapping API
	Route::get('flappings', 'API\FlappingsController@index')->name('flappings');
	Route::get('flappings/last', 'API\FlappingsController@getLast')->name('last');
	Route::get('flappings/{id}/next', 'API\FlappingsController@getNext')->name('next');

	// Probes API
	Route::get('probes', 'API\ProbesController@index')->name('probes');
/*		
	$router->get('hosts', 'HostsController@index');	
	$router->get('host/{id}', 'HostsController@show');	
	$router->post('host', 'HostsController@store');	
	$router->put('host', 'HostsController@update');	
	$router->delete('host/{id}', 'HostsController@destroy');
	$router->get('host-stats', 'HostsController@hostStats');	
	$router->get('host/{id}/pings', 'HostsController@getPings');




	// Probes API
	$router->get('probes', 'ProbesController@index');	
*/

});
