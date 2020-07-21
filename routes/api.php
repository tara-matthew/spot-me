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

Route::get('/spotify/authenticate', 'AuthenticationController@authenticate');
Route::get('/spotify/callback', 'AuthenticationController@redirect');

Route::get('tracks/top', 'TrackController@getTopTracks');
Route::Resource('/tracks', 'TrackController');

Route::get('playlists/export', 'PlaylistController@exportPlaylists');
Route::get('playlists/{playlist}/export', 'PlaylistController@exportPlaylist');
Route::Resource('/playlists', 'PlaylistController');

Route::Resource('/export-playlists', 'PlaylistExportController');