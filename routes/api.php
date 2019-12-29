<?php

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

Route::namespace('Api')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('register', "AuthController@register");
        Route::post('login', "AuthController@login");
        Route::post('social', "AuthController@social");
        Route::post('reset', "AuthController@reset");
        Route::get('refresh', 'AuthController@refresh');

        Route::middleware('auth:api')->group(function () {
            Route::get('user', 'ClientController@user');
            Route::post('password', 'ClientController@password');
            Route::post('subscription', 'ClientController@subscription');
            Route::post('questions', 'ClientController@questions');
            Route::post('update', 'ClientController@update');

            Route::get('logout', 'AuthController@logout');
        });
    });

    Route::middleware('auth:api')->group(function () {
        Route::prefix('messages')->group(function () {
            Route::get('/', 'ChatController@index');
            Route::post('create', 'ChatController@message');
        });

    });

    Route::post('/push/token', 'ClientController@push');

    Route::prefix('horoscope')->group(function () {
        Route::post('/', "IndexController@horoscope");

        Route::middleware('auth:api')->group(function () {
            Route::post('/rate/{horoscope}', "IndexController@rate");
        });
    });
});
