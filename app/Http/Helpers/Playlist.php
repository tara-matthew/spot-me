<?php

namespace App\Http\Helpers;

use SpotifyWebAPI as SpotifyWebApi;

class Playlist
{
    protected $spotify;

    public function __construct(SpotifyWebApi\SpotifyWebAPI $spotify)
    {
        $this->spotify = $spotify;
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

        $info = [];

        $info['playlistTitle'] = $this->spotify->getPlaylist($id)->name;

        foreach ($tracks as $key => $item) {
            $info[$key]['name'] = $item->track->name;
            $info[$key]['artist'] = $item->track->artists[0]->name;
        }

        return $info;
    }

    public function exportToCsv($json)
    {
        $filename = "export.csv";
        $delimiter = ";";

        // open raw memory as file so no temp files needed, you might run out of memory though
        $file = fopen('file.csv', 'w');
        // loop over the input array
        foreach ($json as $line) {
            if (is_array($line)) {
                // generate csv lines from the inner arrays
                fputcsv($file, [$line['name'], $line['artist']]);
            }
        }

        // reset the file pointer to the start of the file
//        fseek($f, 0);
        // tell the browser it's going to be a csv file
//        header('Content-Type: application/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        // make php send the generated csv lines to the browser
//        fpassthru($f);

        fclose($file);
    }
}
