<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::resource('/spotify', 'SpotifyController');
//Route::get('/facade', function() {
//    return SpotifyFacade::
//})

//Route::resource('spotify/callback', 'TestController');

Route::get('/spotify/authenticate', 'AuthenticationController@authenticate');
Route::get('/spotify/callback', 'AuthenticationController@redirect');

Route::get('/spotify/retrieve', 'AuthenticationController@retrieve');
//Route::get('/test', 'TestController@index');