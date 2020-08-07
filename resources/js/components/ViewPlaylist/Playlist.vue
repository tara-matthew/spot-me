<template>
    <v-container v-if="!isLoading">
        <v-row justify="center">
            <v-col cols="6" >
                <h1> {{ playlist.playlistTitle }}</h1>
                <v-btn @click="exportPlaylist">Export this playlist</v-btn>
                <v-btn @click="analysePlaylistTracks">Analyse tracks</v-btn>

                <v-card>
                    <v-list two-line>
                        <template v-for="track in playlist">
                            <v-subheader>
                                {{ track.name }}
                            </v-subheader>
                            <v-list-item>
                                {{ track.artist }}
                            </v-list-item>
                            <v-divider></v-divider>
                        </template>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>
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
