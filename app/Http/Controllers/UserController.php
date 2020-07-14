<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI as SpotifyWebApi;

class UserController extends Controller
{
    protected $spotify;

    public function __construct(SpotifyWebApi\SpotifyWebApi $spotify)
    {
        $this->spotify = $spotify;
    }

    public function retrieve(Request $request) {
        $token = $request->session()->get('token');
        $this->spotify->setAccessToken($token);
        $me = $this->spotify->me();
        $top = $this->spotify->getMyTop('tracks');
//        return response()->json($me->display_name);
        return response()->json($top);
    }

    public function getMyTopTracks(Request $request)
    {
        $token = $request->session()->get('token');
        $this->spotify->setAccessToken($token);

        $topTracks = $this->spotify->getMyTop('tracks');

        // Get the result in json
        $topTracks = response()->json($topTracks);
        
        // Decode the json
        $topTracks = $topTracks->getData();

        $info = [];
        foreach($topTracks->items as $key => $item) {
            $info[$key]['name'] = $item->name;
            $info[$key]['artist'] = $item->album->artists[0]->name;
        }

        return $info;
    }
}
