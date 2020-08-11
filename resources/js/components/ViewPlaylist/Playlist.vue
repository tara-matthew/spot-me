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
        watch: {
          analysis() {
              console.log(this.analysis)
              const playlistLength = Object.keys(this.playlist).length;
              let script = [];
              let number = [];

              // for (var i = 0; i < playlistLength - 2; i++ ) {
              //     script[i] = function (sketch) {
              //         sketch.setup = _ => {
              //             sketch.createCanvas(100, 100)
              //         }
              //         sketch.draw = _ => {
              //             // sketch.background(sketch.random(sketch.analysis['valence'])*10);
              //             // console.log(sketch.analysis['acousticness']);
              //             sketch.background(sketch.random(sketch.analysis['acousticness']))
              //         }
              //     }
              //
              //     // const p5 = require('p5');
              //     // number[i] = new p5(script[i], i.toString())
              //     // number[i].analysis = this.analysis[i];
              //     // console.log(number[0]);
              // }

              const scriptOne = function (sketch) {
                      sketch.setup = _ => {
                          sketch.createCanvas(100, 100)
                      }
                      sketch.draw = _ => {
                          // sketch.background(sketch.random(sketch.analysis['valence'])*10);
                          // console.log(sketch.analysis['acousticness']);
                          sketch.background(sketch.random(sketch.analysis['tempo']))
                      }
                  }

              const scriptTwo = function (sketch) {
                  sketch.setup = _ => {
                      sketch.createCanvas(100, 100)
                  }
                  sketch.draw = _ => {
                      // sketch.background(sketch.random(sketch.analysis['valence'])*10);
                      // console.log(sketch.analysis['acousticness']);
                      sketch.background(sketch.random(sketch.analysis['tempo']))
                  }
              }

              const p5 = require('p5');
              const numberOne = new p5(scriptOne, '0')
              numberOne.analysis = this.analysis[0];
              const numberTwo = new p5(scriptTwo, '1')
              numberTwo.analysis = this.analysis[9];


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

              // new p5(script, '1')
              // console.log(p5);
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
        },

        components: {
            Visualise
        }
    }
</script>
