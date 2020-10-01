<template>
    <v-container fill-height>
        <v-row>
            <v-col @click="goToRoute(playlist.id)" :id="playlist.id" cols="12" md="3" v-for="playlist in playlists" :key="playlist.id">
                <v-card min-height="200" class="pa-2 text-center justify-center d-flex">
                    <v-card-title>{{ playlist.name }}</v-card-title>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        props: [
            'playlists'
        ],
        methods: {
            async exportPlaylists() {
                window.axios.get('/api/playlists/export').then(response => {
                    this.playlists = response.data;
                })
            },

            goToRoute(playlistId) {
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

<style scoped>
    >>>div.v-card__title {
        word-break: break-word; /* maybe !important  */
    }
    >>>div.v-card:hover {
        cursor: pointer;
    }
</style>
