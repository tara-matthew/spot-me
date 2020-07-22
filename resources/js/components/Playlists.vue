<template>
    <v-container>
        <v-btn @click="exportPlaylists">Export my playlists</v-btn>

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
        data() {
            return {
                playlists: null
            }
        },
        mounted() {
            console.log('Component mounted.');
            window.axios.get('/api/playlists').then(response => {
                this.playlists = response.data;
                console.log(this.playlists);
            })
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
                    name:'viewPlaylist',
                    params: {
                        playlistId: playlistId
                    }
                })
            }
        }
    }
</script>
