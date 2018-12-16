<?php

use Illuminate\Support\Facades\Route;
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

Route::group(['as' => 'api.'], function ()
{
    Route::post('register', 'API\AuthController@register');
    Route::post('login', 'API\AuthController@login');
    Route::get('hosts-stats', 'API\HostsController@hostStats')->name('hoststats');
    Route::get('ip_addresses', 'API\HostsController@ipAddresses')->name('ip_addresses');
    Route::get('services-stats', 'API\ServicesController@serviceStats')->name('servicestats');
});
Route::group(['middleware' => 'auth:api', 'prefix' => '', 'as' => 'api.'], function () {

        Route::post('logout', 'API\AuthController@logout');
        Route::get('whoami', function (Request $request) {
            if ($request->user()) {
                \Log::info('auth user requested ' . $request->user()->email);
                return $request->user();
            } else {
                \Log::info('non-auth user requested ');
                return \Response::json(['error' => 'Not nought privileges'], 401);
            }
        });
//        Route::get('notification', function (Request $request) {
//            return $request->user()->notify("Hi there");
//        });

        // Roles API
        Route::get('roles', 'API\RolesController@index')->name('roles');
        Route::get('roles/{id}', 'API\RolesController@show')->name('roles');
        Route::get('roles/{id}/permissions', 'API\RolesController@permissions')->name('roles_permissions');
        Route::put('roles', 'API\RolesController@update')->name('roles');
        Route::post('roles', 'API\RolesController@store')->name('roles');
        Route::delete('roles/{id}', 'API\RolesController@destroy')->name('roles');

        // Users API
        Route::get('users', 'API\UsersController@index')->name('users');
        Route::get('users/{id}', 'API\UsersController@show')->name('users');
        Route::put('users', 'API\UsersController@update')->name('users');
        Route::post('users', 'API\UsersController@store')->name('users');
        Route::delete('users/{id}', 'API\UsersController@destroy')->name('users');

        // Services API
        Route::get('services', 'API\ServicesController@index')->name('services');
        Route::get('services/{id}', 'API\ServicesController@show')->name('services');
        Route::put('services', 'API\ServicesController@update')->name('services');
        Route::post('services', 'API\ServicesController@store')->name('services');
        Route::delete('services/{id}', 'API\ServicesController@destroy')->name('services');

//        Route::get('services-stats', 'API\ServicesController@serviceStats')->name('servicestats');
        Route::get('services/{id}/observations', 'API\ServicesController@getObservations')->name('getobservations');
        Route::get('services/{id}/lasthourobservations', 'API\ServicesController@getLastHourObservations')->name('getlasthourobservations');

        // Hosts API
        Route::get('dashboard_hosts', 'API\HostsController@dashboard')->name('dashboardhosts');
        Route::get('hosts', 'API\HostsController@index')->name('hosts');
        Route::get('hosts/{id}', 'API\HostsController@show')->name('hosts');
        Route::put('hosts', 'API\HostsController@update')->name('hosts');
        Route::post('hosts', 'API\HostsController@store')->name('hosts');
        Route::delete('hosts/{id}', 'API\HostsController@destroy')->name('hosts');

//        Route::get('hosts-stats', 'API\HostsController@hostStats')->name('hoststats');
        Route::get('hosts/{id}/services', 'API\HostsController@hostServices')->name('hostservices');

        // Flapping API
        Route::get('flappings', 'API\FlappingsController@index')->name('flappings');
        Route::get('flappings/last', 'API\FlappingsController@getLast')->name('last');
        Route::get('flappings/{id}/next', 'API\FlappingsController@getNext')->name('next');

        // Probes API
        Route::get('probes', 'API\ProbesController@index')->name('probes');

        // Permissions API
        Route::get('permission', 'API\PermissionsController@index')->name('permissions');
});
