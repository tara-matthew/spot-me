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
        $tracks = $this->getTracks($playlistId);
        $ids = $this->getTrackIds($tracks);

        $analysis = response()
            ->json($this->spotify->getAudioFeatures($ids));

        return $this->formatAnalysis($analysis);
    }

    /**
     * Get a playlist's tracks in a format to be displayed
     * @param $id
     * @return array
     */
    public function getTracks($id)
    {
        $tracks = $this->spotify->getPlaylistTracks($id);
        // Get the result in json
        $tracks = response()->json($tracks);
        // Decode the json
        $tracks = $tracks->getData()->items;

        return $tracks;
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
        $tracks = $this->getTracks($id);
        $formattedTracks = $this->formatTracks($tracks, $id);

        return $formattedTracks;
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

        $data = $tracks->getData()->audio_features;
//        dd($data);
        $analysis = [];

        foreach ($data as $key => $track) {
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
        $payload = request()->getContent();
        $tracks = $this->getTracks($id);
        $info = $this->formatTracks($tracks, $id);

        $this->pdf->export($info, $payload);

//        $filename = "export.csv";
//        $delimiter = ";";
//
//        // open raw memory as file so no temp files needed, you might run out of memory though
//        $file = fopen('file.csv', 'w');
//        // loop over the input array
//        foreach ($info as $line) {
//            if (is_array($line)) {
//                // generate csv lines from the inner arrays
//                fputcsv($file, [$line['name'], $line['artist']]);
//            }
//        }
//
//        // reset the file pointer to the start of the file
////        fseek($f, 0);
//        // tell the browser it's going to be a csv file
////        header('Content-Type: application/csv');
//        // tell the browser we want to save it instead of displaying it
//        header('Content-Disposition: attachment; filename="' . $filename . '";');
//        // make php send the generated csv lines to the browser
////        fpassthru($f);
//
//        fclose($file);
    }
}
