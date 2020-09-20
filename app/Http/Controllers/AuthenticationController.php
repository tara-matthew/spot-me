<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI;
use SpotifyWebAPI\Session;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    protected $spotify;

    public function __construct(SpotifyWebApi\SpotifyWebApi $spotify)
    {
        $this->spotify = $spotify;

        $this->session = new Session(
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

        $request->session()->put('token', $accessToken);
        $request->session()->put('refreshToken', $refreshToken);

        $request->session()->put('spotify', $this->session);

        return redirect('playlists');
    }

    public function refreshToken(Request $request)
    {
        $refreshToken = $request->refreshToken;
        $this->session->refreshAccessToken($refreshToken);
        $accessToken = $this->session->getAccessToken();
        $request->session()->put('token', $accessToken);
        $request->session()->put('spotify', $this->session);

        return redirect('playlists');

    }
}
