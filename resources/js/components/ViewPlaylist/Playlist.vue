<template>
    <v-container>
        <h1> {{ playlist.playlistTitle }}</h1>
        <v-btn v-if="!isLoading" @click="exportPlaylist">Export this playlist</v-btn>
        <v-btn v-if="!isLoading" @click="analysePlaylistTracks">Analyse tracks</v-btn>

        <v-list>
            <v-list-item-group>
                <v-list-item
                        v-for="track in playlist" :key="track.id">
                    {{ track.artist }} - {{ track.name }}
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-container>
</template>

<script>
    export default {
        props: [
            'playlist',
            'isLoading'
        ],
        data() {
            return {
                analysis: null
            }
        },
        mounted() {
            console.log('Playlist component mounted.');
        },

        methods: {
            exportPlaylist() {
                const playlistId = this.$route.params.playlistId;
                window.axios.get('/api/playlists/' + playlistId + '/export').then(response => {
                    this.playlist = response.data;
                })
            },
            analysePlaylistTracks() {
                const playlistId = this.$route.params.playlistId;
                window.axios.get('/api/playlists/' + playlistId + '/analyse').then(response => {
                    this.analysis = response.data;
                    console.log(this.analysis);
                })
            }
        }
    }
</script>
