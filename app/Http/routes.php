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
        $app->get('/locales', ['uses' => 'IndexController@locales']);
        $app->get('/locales/{locale}/answers', ['uses' => 'IndexController@answers']);
    }
);

$app->get('/admin/login', function () {
    return Auth::guest() ? view('login.twig') : redirect('/admin/answers/default', 301);
});
$app->post('/admin/login', ['uses' => 'IndexController@login']);


$app->group(
    [
        'prefix' => 'admin',
        'namespace' => 'App\Http\AdminControllers',
        'middleware' => ['auth'],
    ],
    function ($app) {
        $app->get('/', ['uses' => 'IndexController@index']);

        $app->get('/locales', ['uses' => 'LocalesController@index']);
        $app->get('/locales/create', ['uses' => 'LocalesController@create']);
        $app->get('/locales/update/{id}', ['uses' => 'LocalesController@update']);
        $app->get('/locales/delete/{id}', ['uses' => 'LocalesController@delete']);
        $app->post('/locales/edit', ['uses' => 'LocalesController@edit']);

        $app->get('/answers/{locale}', ['uses' => 'AnswersController@index']);
        $app->get('/answers/{locale}/create', ['uses' => 'AnswersController@create']);
        $app->get('/answers/{id}/update', ['uses' => 'AnswersController@update']);
        $app->get('/answers/{id}/delete', ['uses' => 'AnswersController@delete']);
        $app->post('/answers/edit', ['uses' => 'AnswersController@edit']);

        $app->get('/users', ['uses' => 'UsersController@index']);
        $app->get('/users/create', ['uses' => 'UsersController@create']);
        $app->get('/users/{id}/update', ['uses' => 'UsersController@update']);
        $app->get('/users/{id}/delete', ['uses' => 'UsersController@delete']);
        $app->post('/users/edit', ['uses' => 'UsersController@edit']);
    }
);
