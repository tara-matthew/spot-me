<?php

namespace App\Http\Helpers;

use SpotifyWebAPI as SpotifyWebApi;

class Playlist
{
    protected $spotify;

    public function __construct(SpotifyWebApi\SpotifyWebApi $spotify)
    {
        $this->spotify = $spotify;
    }

    public function getPlaylistData()
    {
        $api = $this->spotify;

        $options = ['limit' => 50];
        $userPlaylists = [];

        $userId = $api->me()->id;

        $playlists = (response()
            ->json($api->getUserPlaylists($userId, $options))
            ->getData()
            ->items);

        $key = 0;

        foreach($playlists as $playlist) {
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

    public function getTracks()
    {
        $api = $this->spotify;
        $playlistData = $this->getPlaylistData($api);

        $tracks = $api->getPlaylistTracks($playlistData[0]['id']);

        // Get the result in json
        $tracks = response()->json($tracks);

        // Decode the json
        $tracks = $tracks->getData()->items;

        $info = [];

        foreach($tracks as $key => $item) {
            $info[$key]['name'] = $item->track->name;
            $info[$key]['artist'] = $item->track->artists[0]->name;
        }

        return $info;

    }

    public function exportToCsv($json)
    {
        $filename = "export.csv";
        $delimiter=";";

        // open raw memory as file so no temp files needed, you might run out of memory though
        $file = fopen('file.csv', 'w');
        // loop over the input array
        foreach ($json as $line) {
            // generate csv lines from the inner arrays
            fputcsv($file, [$line['name']]);
        }
        // reset the file pointer to the start of the file
//        fseek($f, 0);
        // tell the browser it's going to be a csv file
//        header('Content-Type: application/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        // make php send the generated csv lines to the browser
//        fpassthru($f);

        fclose($file);
    }
}
