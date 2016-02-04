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
$app->group(
    [
        'prefix' => 'api/v1',
        'namespace' => 'App\Http\Controllers',
    ],
    function ($app) {
        $app->get('/', ['uses' => 'IndexController@welcome']);
    }
);

$app->group(
    [
        'prefix' => 'admin',
        'namespace' => 'App\Http\AdminControllers',
    ],
    function ($app) {
        $app->get('/', ['uses' => 'IndexController@index']);

        $app->get('/locales', ['uses' => 'LocalesController@index']);
        $app->get('/locales/create', ['uses' => 'LocalesController@create']);
        $app->post('/locales/edit', ['uses' => 'LocalesController@edit']);
        $app->get('/locales/update/{id}', ['uses' => 'LocalesController@update']);
        $app->get('/locales/delete/{id}', ['uses' => 'LocalesController@delete']);

        $app->get('/{template}.html', ['uses' => 'IndexController@index']);
    }
);
