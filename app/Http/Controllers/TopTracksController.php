<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI as SpotifyWebApi;

class TopTracksController extends Controller
{
    protected $spotify;

    public function __construct(SpotifyWebApi\SpotifyWebApi $spotify)
    {
        $this->spotify = $spotify;
    }

    public function index(Request $request)
    {
        $token = $request->session()->get('token');
        $this->spotify->setAccessToken($token);
        $options = ['limit' => 50];
        $topTracks = $this->spotify->getMyTop('tracks', $options);

        // Get the result in json
        $topTracks = response()->json($topTracks);

        // Decode the json
        $topTracks = $topTracks->getData()->items;

        $info = [];
        foreach($topTracks as $key => $item) {
            $info[$key]['name'] = $item->name;
            $info[$key]['artist'] = $item->album->artists[0]->name;
        }

        return $info;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}