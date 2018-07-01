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

    //API authenticate group
    Route::group([
        'middleware' => ['auth:api']
    ], function () {
        Route::post('/logout', [
            'as' => 'logout',
            'uses' => 'AuthController@logout'
        ]);
    });
});

//Login
//Route::post('login', [
//
//]);
//
//Route::group([
//    'as' => 'api.',
//], function () {
//    Route::get('test', function () {
//        $user = \ImageGellery\User::find(1);
//        $token = $user->createToken($user->email);
//
//        return response()->json([
//            'access_token' => $token->accessToken,
//            'token_id' => $token->token->id
//        ]);
//    });
//});
//
//Route::get('/test2', function () {
//    return 'ok';
//})->middleware('auth:api');