<template>
    <v-container v-if="!isLoading">
        <v-row justify="center">
            <v-col cols="6" >
                <h1> {{ playlist.playlistTitle }}</h1>
                <v-btn @click="exportPlaylist">Export this playlist</v-btn>
                <v-btn @click="analysePlaylistTracks">Analyse tracks</v-btn>

                <v-card>

                    <v-list two-line>
                        <template v-for="(track, index) in playlist">
                            <v-row>
                                <v-col>
                                    <v-subheader>
                                        {{ track.name }}
                                    </v-subheader>
                                    <v-list-item>
                                        {{ track.artist }}
                                    </v-list-item>
                                    <v-divider></v-divider>
                                </v-col>
                                <v-col>
                                    <div :id="index"></div>
                                </v-col>
                            </v-row>
                        </template>
                    </v-list>

                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import Visualise from '@/js/components/ViewPlaylist/Visualise'

    export default {
        props: [
            'playlist',
            'analysis',
            'isLoading',
            'p5Loaded'
        ],
        // data() {
        //     return {
        //         analysis: null
        //     }
        // },

        watch: {
          analysis() {
              console.log('here', this.analysis);
          }
        },

        updated() {
            console.log('Playlist component mounted.');
            const script = function (sketch) {
                // NOTE: Set up is here
                sketch.setup = _ => {
                    sketch.createCanvas(100, 100)
                    sketch.background(sketch.random(255));


                }
                // NOTE: Draw is here
                sketch.draw = _ => {
                    // console.log('hereeee', sketch.playlist)

                }
            }

            // const script2 = function (p5) {
            //     var speed = 2;
            //     var posX = 0;
            //
            //     // NOTE: Set up is here
            //     p5.setup = _ => {
            //         p5.createCanvas(100, 100)
            //         // p5.canvas.parent("America");
            //         p5.background(p5.random(255));
            //
            //     }
            //     // NOTE: Draw is here
            //     p5.draw = _ => {
            //     }
            // }
            // NOTE: Use p5 as an instance mode
            const p5 = require('p5');
            const numberOne = new p5(script, '0')
            numberOne.playlist = this.playlist;
            // new p5(script, '1')
            // console.log(p5);


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
        },

        components: {
            Visualise
        }
    }
</script>
