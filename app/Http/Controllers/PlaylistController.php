<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI as SpotifyWebApi;
use App\Http\Helpers\Playlist;
use App\Http\Helpers\Export;

class PlaylistController extends Controller
{
    protected $spotify;
    protected $playlist;

    public function __construct(SpotifyWebApi\SpotifyWebApi $spotify)
    {
        $this->spotify = $spotify;
        $this->playlist = new Playlist($spotify);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $api = $this->spotify;
        $token = $request->session()->get('token');
        $api->setAccessToken($token);

        $playlistData = $this->playlist->getPlaylistData();

        return $playlistData;
    }

    public function exportPlaylists(Request $request)
    {
        $api = $this->spotify;

        $token = $request->session()->get('token');
        $api->setAccessToken($token);

//        $playlist = new Playlist();
        $playlistData = $this->playlist->getPlaylistData($api);
        $this->playlist->exportToCsv($playlistData);

        return $playlistData;
    }

    public function exportPlaylist(Request $request)
    {
        dd('single playlist');
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
    public function show($id, Request $request)
    {
        $api = $this->spotify;
    
        $token = $request->session()->get('token');
        $api->setAccessToken($token);

        $tracks = $api->getPlaylistTracks($id);

        // Get the result in json
        $tracks = response()->json($tracks);

        // Decode the json
        $tracks = $tracks->getData()->items;

        $info = [];

        $info['playlistTitle'] = $api->getPlaylist($id)->name;

        foreach($tracks as $key => $item) {
            $info[$key]['name'] = $item->track->name;
            $info[$key]['artist'] = $item->track->artists[0]->name;
        }

        return $info;

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
