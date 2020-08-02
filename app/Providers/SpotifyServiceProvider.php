<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use SpotifyWebAPI;
use Illuminate\Support\Facades\DB;

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
            $token = DB::select('select token from authentication where id = ?', [1]);
            $client->setAccessToken($token[0]->token);

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
