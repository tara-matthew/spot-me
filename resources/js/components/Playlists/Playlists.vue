<template>
    <v-container>
        <v-list>
            <v-list-item-group>
                <v-list-item
                        @click="goToRoute"
                        v-for="playlist in playlists" :key="playlist.id" :id="playlist.id">
                    {{ playlist.name }}
                </v-list-item>
            </v-list-item-group>
        </v-list>

    </v-container>
</template>

<script>
    export default {
        props: [
            'playlists'
        ],
        mounted() {
            console.log('Playlist Component mounted.');
        },
        watch: {
            async playlists() {
                console.log('here', this.playlists);
            }
        },
        methods: {
            async exportPlaylists() {
                window.axios.get('/api/playlists/export').then(response => {
                    this.playlists = response.data;
                })
            },

            goToRoute() {
                const playlistId = event.target.id
                this.$router.push({
                    name: 'viewPlaylist',
                    params: {
                        playlistId: playlistId
                    }
                })
            }
        }
    }
</script>
