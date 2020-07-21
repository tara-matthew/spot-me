<template>
    <v-container>
        <v-btn @click="getTopTracks">Get my top tracks</v-btn>

        <v-list>
            <v-list-item-group>
                <v-list-item
                    v-for="track in tracks" :key="track.name">
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
                tracks: null
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            async getTopTracks() {

                window.axios.get('/api/tracks/top').then(response => {
                    this.tracks = response.data;
                    console.log(this.tracks);

                })

            }
        }
    }
</script>
