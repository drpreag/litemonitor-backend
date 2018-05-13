<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function() use ($router) {
	
	// Users API
	$router->get('users', 'UsersController@index');
	$router->get('user/{id}', 'UsersController@show');
	$router->post('user', 'UsersController@store');	
	$router->put('user', 'UsersController@update');
	$router->delete('user/{id}', 'UsersController@destroy');

	// Users API
	$router->get('roles', 'RolesController@index');
	$router->get('role/{id}', 'RolesController@show');
	$router->post('role', 'RolesController@store');	
	$router->put('role', 'RolesController@update');
	$router->delete('role/{id}', 'RolesController@destroy');

	// Services API
	$router->get('services', 'ServicesController@index');	
	$router->get('service/{id}', 'ServicesController@show');
	$router->post('service', 'ServicesController@store');
	$router->put('service', 'ServicesController@update');
	$router->delete('service/{id}', 'ServicesController@destroy');
	$router->get('service-stats', 'ServicesController@serviceStats');
	$router->get('service/{id}/observations', 'ServicesController@getObservations');

	// Hosts API
	$router->get('hosts', 'HostsController@index');	
	$router->get('host/{id}', 'HostsController@show');	
	$router->post('host', 'HostsController@store');	
	$router->put('host', 'HostsController@update');	
	$router->delete('host/{id}', 'HostsController@destroy');
	$router->get('host-stats', 'HostsController@hostStats');	
	$router->get('host/{id}/pings', 'HostsController@getPings');


	// Flapping API
	$router->get('flappings', 'FlappingsController@index');	

	// Probes API
	$router->get('probes', 'ProbesController@index');	

});
