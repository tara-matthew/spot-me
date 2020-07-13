<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use SpotifyWebAPI;

ob_start();



class SpotifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Spotify', function ($app) {
            $client = new SpotifyWebApi\SpotifyWebApi;

            $session = new SpotifyWebAPI\Session(
                env('SPOTIFY_CLIENT_ID'),
                env('SPOTIFY_CLIENT_SECRET'),
                env('SPOTIFY_CALLBACK_URL')
            );

            $scopes = [
                'playlist-read-private',
                'user-read-private',
            ];

//            dd($session);

//            $session->requestCredentialsToken($scopes);

//            $accessToken = $session->getAccessToken();

//            $client->setAccessToken($accessToken);
//            dd($session->getAuthorizeUrl($scopes));
//            return redirect()->away($session->getAuthorizeUrl());
//            die();
//            dd($session->getAuthorizeUrl($scopes));
//            dd($client);

//            if (headers_sent()) {
//                die("Error: headers already sent!");
//            } else {
//                header("Location: https://accounts.spotify.com");
//                exit();
//            }


//            die();



            return $client;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
