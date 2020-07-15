<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI as SpotifyWebApi;


class AuthenticationController extends Controller
{
    protected $spotify;

    public function __construct(SpotifyWebApi\SpotifyWebApi $spotify)
    {
        $this->spotify = $spotify;

        $this->session = new SpotifyWebAPI\Session(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            env('SPOTIFY_CALLBACK_URL')
        );

        $this->options = [
            'scope' => [
                'playlist-read-private',
                'user-read-private',
                'user-top-read'
            ],
        ];
    }

    public function authenticate()
    {
        return $this->session->getAuthorizeUrl($this->options);
    }

    public function redirect(Request $request)
    {
        $code = $request->get('code');
        $this->session->requestAccessToken($code);
        $accessToken = $this->session->getAccessToken();
        $refreshToken = $this->session->getRefreshToken();

        $this->spotify->setAccessToken($accessToken);

        // Save the token in the session for now
        $request->session()->put('token', $accessToken);

        return redirect('about');
    }
}
