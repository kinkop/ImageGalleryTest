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

Route::group([
    'namespace' => 'Api\\',
    'as' => 'api.'
], function () {
    //Login
    Route::post('/login', [
        'as' => 'login',
        'uses' => 'AuthController@login'
    ]);

    //Create user
    Route::post('/user', [
        'as' => 'user.store',
        'uses' => 'UserController@store'
    ]);

    //API authentication group
    Route::group([
        'middleware' => ['auth:api']
    ], function () {
        //Logout
        Route::post('/logout', [
            'as' => 'logout',
            'uses' => 'AuthController@logout'
        ]);

        //Image upload resource
        Route::resource('/image-upload', 'ImageUploadController');
    });
});