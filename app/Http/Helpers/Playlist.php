<?php

namespace App\Http\Helpers;

use SpotifyWebAPI;
use App\Http\Helpers\Pdf;

class Playlist
{
    protected $spotify;

    public function __construct(SpotifyWebApi\SpotifyWebAPI $spotify)
    {
        $this->spotify = $spotify;
        $this->pdf = new Pdf;
    }

    /**
     * Get the playlists which a user has made
     * @return array
     */
    public function getUserPlaylists()
    {
        $options = ['limit' => 50];
        $userPlaylists = [];

        $userId = $this->spotify->me()->id;

        $playlists = (response()
            ->json($this->spotify->getUserPlaylists($userId, $options))
            ->getData()
            ->items);

        $key = 0;

        foreach ($playlists as $playlist) {
            //s Skip over playlists not made by the current user
            if ($playlist->owner->uri != 'spotify:user:' . $userId) {
                continue;
            }

            $userPlaylists[$key]['id'] = $playlist->id;
            $userPlaylists[$key]['name'] = $playlist->name;
            $userPlaylists[$key]['position'] = $key + 1;

            $key++;
        }

        return $userPlaylists;

    }

    public function analysePlaylistTracks($playlistId)
    {

        $trackCount = $this->getTrackCount($playlistId);
        $apiCallsRequired =  ceil($trackCount / 100);
        $ids = [];
        $analysis = [];
        $type = 'tracks';

        $tracks = $this->getAll($apiCallsRequired, $playlistId, $type);

        foreach($tracks as $track) {
            $ids[] = $this->getTrackIds($track);
        }

        foreach($ids as $id) {
            $analysis[] = response()
                ->json($this->spotify->getAudioFeatures($id));
        }

        return $this->formatAnalysis($analysis);
    }

    /**
     * Get a playlist's tracks in a format to be displayed
     * @param $id
     * @param $offset
     * @return array
     */
    public function getTracks($id, $offset = 0)
    {
        $tracks = $this->spotify->getPlaylistTracks($id, ['offset' => $offset]);
        // Get the result in json
        $tracks = response()->json($tracks);
        // Decode the json
        $tracks = $tracks->getData()->items;

        return $tracks;
    }

    public function getTrackCount($id)
    {
        $tracks = $this->spotify->getPlaylistTracks($id);
        return $tracks->total;
    }

    public function getTrackIds($tracks)
    {
        $ids = [];
        foreach ($tracks as $key => $track) {
            $ids[] = $track->track->id;
        }

        return $ids;
    }

    public function getAudioAnalysis($ids)
    {
        $analysis = $this->spotify->getAudioFeatures($ids);
        $analysis = response()->json($analysis);

        return $analysis;

    }

    public function getFormattedTracks($id)
    {
        $trackCount = $this->getTrackCount($id);
        $apiCallsRequired =  ceil($trackCount / 100);

        $type = 'tracks';

        $tracks = $this->getAll($apiCallsRequired, $id, $type);

        $mergedTracks = $this->mergeArray($tracks);

        $formattedTracks = $this->formatTracks($mergedTracks, $id);

        return $formattedTracks;
    }

    public function mergeArray($array)
    {
        $merged = [];

        foreach($array as $tempArray) {
            $merged = array_merge($merged, $tempArray);
        }

        return $merged;
    }

    public function getAll($apiCallsRequired, $id, $type = 'tracks')
    {
        $all = [];

        for ($i = 0; $i < $apiCallsRequired; $i++) {
            //TODO make type into a constant int
            if ($type == 'tracks') {
                $all[] = $this->getTracks($id, $i * 100);
            }
        }

        return $all;
    }

    public function formatTracks($tracks, $playlistId)
    {
        $info = [];

        $info['info']['playlistTitle'] = $this->spotify->getPlaylist($playlistId)->name;

        foreach ($tracks as $key => $item) {
            $info['tracks'][$key]['name'] = $item->track->name;
            $info['tracks'][$key]['artist'] = $item->track->artists[0]->name;
        }

        return $info;
    }

    public function formatAnalysis($tracks)
    {
        $excludedCategories = [
            'type',
            'id',
            'uri',
            'track_href'
        ];

        $data = [];
        $analysis = [];

        foreach($tracks as $track) {
            $data[] = $track->getData()->audio_features;
        }

        $mergedAnalysis = $this->mergeArray($data);

        foreach ($mergedAnalysis as $key => $track) {
            foreach ($track as $category => $value) {
                if (in_array($category, $excludedCategories)) {
                    continue;
                }

                $analysis[$key][$category] = $value;
            }
        }

        return $analysis;
    }

    public function exportToCsv($id)
    {
        $payload = json_decode(request()->getContent(), true);
        $info = $this->getFormattedTracks($id);

        foreach($info['tracks'] as $key => $track) {
            $info['tracks'][$key]['image'] = $payload['dataUrls'][$key];
        }

        $this->pdf->export($info);
    }
}
