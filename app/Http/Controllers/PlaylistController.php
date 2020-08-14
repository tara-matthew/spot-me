<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI as SpotifyWebApi;
use App\Http\Helpers\Playlist;
use Illuminate\Support\Facades\DB;

class PlaylistController extends Controller
{
    protected $spotify;
    protected $playlist;

    public function __construct(SpotifyWebApi\SpotifyWebAPI $spotify)
    {
        $this->spotify = $spotify;
        $this->playlist = new Playlist($this->spotify);

        $this->middleware(function ($request, $next) {
           $token = $request->session()->get('token');
           $this->spotify->setAccessToken($token);

           return $next($request);
        });
    }

    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        return $this->playlist->getUserPlaylists();
    }

    public function analysePlaylistTracks($id)
    {
        return $this->playlist->analysePlaylistTracks($id);
    }

    public function exportPlaylists()
    {
        $playlistData = $this->playlist->getUserPlaylists($this->spotify);
        $this->playlist->exportToCsv($playlistData);

        return $playlistData;
    }

    public function exportPlaylist($id)
    {
        $this->playlist->exportToCsv($id);
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
    public function show($id)
    {
        return $this->playlist->getFormattedTracks($id);
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
