<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI as SpotifyWebApi;
use App\Http\Helpers\Playlist;

class PlaylistController extends Controller
{
    protected $spotify;
    protected $playlist;

    public function __construct(SpotifyWebApi\SpotifyWebAPI $spotify)
    {
        $this->spotify = $spotify;
        $this->playlist = new Playlist($this->spotify);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        // authentication
        $token = $request->session()->get('token');
        $this->spotify->setAccessToken($token);

        $playlistData = $this->playlist->getUserPlaylists();

        return $playlistData;
    }

    public function analysePlaylistTracks($id, Request $request)
    {
        $token = $request->session()->get('token');
        $this->spotify->setAccessToken($token);

        $tracks = $this->playlist->getTracks($id);
        $ids = $this->playlist->getTrackIds($tracks);

        $analysis = response()
            ->json($this->spotify->getAudioFeatures($ids));

        $analysis = $this->playlist->formatAnalysis($analysis);

        return $analysis;
    }

    public function exportPlaylists(Request $request)
    {
        $token = $request->session()->get('token');
        $this->spotify->setAccessToken($token);

        $playlistData = $this->playlist->getUserPlaylists($this->spotify);
        $this->playlist->exportToCsv($playlistData);

        return $playlistData;
    }

    public function exportPlaylist($id, Request $request)
    {
        // Authentication
        $token = $request->session()->get('token');
        $this->spotify->setAccessToken($token);

        $tracks = $this->spotify->getPlaylistTracks($id);
        // Get the result in json
        $tracks = response()->json($tracks);
        // Decode the json
        $tracks = $tracks->getData()->items;

        $info = $this->playlist->getTracks($id);

        $info['playlistTitle'] = $this->spotify->getPlaylist($id)->name;

        foreach ($tracks as $key => $item) {
            $info[$key]['name'] = $item->track->name;
            $info[$key]['artist'] = $item->track->artists[0]->name;
        }

        $this->playlist->exportToCsv($info);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function show($id, Request $request)
    {
        // Authentication
        $token = $request->session()->get('token');
        $this->spotify->setAccessToken($token);

        $tracks = $this->playlist->getTracks($id);
        $formattedTracks = $this->playlist->formatTracks($tracks, $id);

        return $formattedTracks;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
