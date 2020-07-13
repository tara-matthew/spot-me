<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI as SpotifyWebApi;


class AuthenticationController extends Controller
{
    public function __construct()
    {
        $this->spotify = new SpotifyWebApi\SpotifyWebAPI;
        $this->session = new SpotifyWebAPI\Session(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            env('SPOTIFY_CALLBACK_URL'));

        // Request a access token with optional scopes
        $scopes = array(
            'playlist-read-private',
            'user-read-private'
        );

    }

    public function authenticate()
    {
        return $this->session->getAuthorizeUrl();
    }

    public function redirect(Request $request)
    {
//        dd('here');
        $code = $request->get('code');
        $this->session->requestAccessToken($code);
        $this->spotify->setAccessToken($this->session->getAccessToken());
        dd($this->spotify);
//        dd($code);
        // Save the token

//        $redirect = $request->session()->get('redirect', 'test');

        return redirect('about');
    }

    public function retrieve()
    {
        dd($this->session);
        dd($this->spotify->getTrack('7EjyzZcbLxW7PaaLua9Ksb'));
    }
}
