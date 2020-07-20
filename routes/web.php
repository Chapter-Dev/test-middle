<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
$router->get('/init','SettingsController@getInitCredentials');
$router->group(['middleware' => 'csrf'],function() use($router){
    $router->group(['prefix' => '/user'], function() use($router){
        $router->post('/profile','UserController@profile');
        $router->get('/login','UserController@login');
        $router->get('/login/{token}','UserController@loginSubmit');
        $router->post('/create','UserController@register');
        $router->post('{uuid}/update','UserController@update');
    });
});
