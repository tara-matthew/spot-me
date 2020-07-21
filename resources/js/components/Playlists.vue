<template>
    <v-container>
        <v-btn @click="getPlaylists">Get my playlists</v-btn>
        <v-btn @click="exportPlaylists">Export my playlists</v-btn>


        <!--<v-list>-->
            <!--<v-list-item-group>-->
                <!--<v-list-item-->
                        <!--v-for="track in tracks" :key="track.name">-->
                    <!--{{ track.artist }} - {{ track.name }}-->
                <!--</v-list-item>-->
            <!--</v-list-item-group>-->
        <!--</v-list>-->

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
            console.log('Component mounted.')
        },
        methods: {
            async getPlaylists() {

                window.axios.get('/api/playlists').then(response => {
                    this.playlists = response.data;
                    // console.log(this.playlists);
                })

            },

            async exportPlaylists() {
                window.axios.get('/api/playlists/export').then(response => {
                    this.playlists = response.data;
                    console.log(this.playlists);

                })
            }
        }
    }
</script>
