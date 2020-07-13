<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI as SpotifyWebApi;


class AuthenticationController extends Controller
{
    protected $spotify;
//    public function __construct()
//    {
//        $this->spotify = new SpotifyWebApi\SpotifyWebAPI;
//        $this->session = new SpotifyWebAPI\Session(
//            env('SPOTIFY_CLIENT_ID'),
//            env('SPOTIFY_CLIENT_SECRET'),
//            env('SPOTIFY_CALLBACK_URL'));
//
//        // Request a access token with optional scopes
//        $scopes = array(
//            'playlist-read-private',
//            'user-read-private'
//        );
//
//    }

    public function __construct(SpotifyWebApi\SpotifyWebApi $spotify)
    {
        $this->spotify = $spotify;

        $this->session = new SpotifyWebAPI\Session(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            env('SPOTIFY_CALLBACK_URL')
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
        $token = $this->session->getAccessToken();
        $this->spotify->setAccessToken($this->session->getAccessToken());
        // Save the token in the session for now

        $request->session()->put('token', $token);

        return redirect('about');
    }

    public function retrieve(Request $request)
    {
        $token = $request->session()->get('token');
        $this->spotify->setAccessToken($token);

        dd($this->spotify->me());
    }
}
