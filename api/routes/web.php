<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Str;

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

$router->get('/key', function() {
  // return Str::random(32);
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/{id}/athlete', ['middleware' => 'auth', 'uses' => 'Strava\AthleteController@index']);
$router->get('/{id}/athlete/stats', ['middleware' => 'auth', 'uses' => 'Strava\AthleteController@stats']);

// strava authentication
$router->post('/exchange_token', 'Strava\AuthorizationController@store');
$router->delete('/strava/{id}', 'Strava\AuthorizationController@destroy');

$router->post('/users', 'Frontend\UsersController@register');
$router->post('/login', 'Frontend\LoginController@index');
