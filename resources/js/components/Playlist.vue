<template>
    <v-container>
        <h1 v-if="playlist">{{ playlist.playlistTitle }}</h1>
        <v-btn @click="exportPlaylist">Export this playlist</v-btn>

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
        data() {
            return {
                playlist: null
            }
        },
        async mounted() {
            console.log('Playlist component mounted.');
            const playlistId = this.$route.params.playlistId;
            console.log(playlistId);

            window.axios.get('/api/playlists/' + playlistId).then(response => {
                this.playlist = response.data;
            })
        },

        methods: {
            exportPlaylist() {
                const playlistId = this.$route.params.playlistId;
                window.axios.get('/api/playlists/' + playlistId + '/export').then(response => {
                    this.playlist = response.data;
                })
            }
        }
    }
</script>
