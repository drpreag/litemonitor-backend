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
	$router->put('user', 'UsersController@store');
	$router->delete('user/{id}', 'UsersController@destroy');

	// Services API
	$router->get('services', 'ServicesController@index');	
	$router->get('service-stats', 'ServicesController@serviceStats');

	// Hosts API
	$router->get('hosts', 'HostsController@index');	
	$router->get('host/{id}', 'HostsController@show');	
	$router->post('host', 'HostsController@store');	
	$router->put('host', 'HostsController@update');
	$router->delete('host/{id}', 'HostsController@destroy');
	$router->get('host-stats', 'HostsController@hostStats');	

	// Flapping API
	$router->get('flappings', 'FlappingsController@index');	


});
