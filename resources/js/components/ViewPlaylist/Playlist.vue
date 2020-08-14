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
                                    <div :id="index" :ref="'canvas' + index"></div>
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

              for (var i = 0; i < playlistLength - 1; i++ ) {
                  script[i] = function (sketch) {
                      let angle = 0;
                      sketch.setup = _ => {
                          sketch.angleMode(sketch.DEGREES);
                          sketch.createCanvas(100, 100)
                      }
                      sketch.draw = _ => {
                          sketch.noLoop()
                          sketch.background(sketch.analysis['tempo'])
                          angle = sketch.map((sketch.analysis['danceability'])*100, 0, 100, 0, 180)-180;
                          sketch.stroke(255);
                          sketch.translate(50, sketch.height);
                          sketch.branch(40);
                      }

                      sketch.branch = (len) => {
                          sketch.line(0, 0, 0, -len);
                          sketch.translate(0, -len);
                          if (len > 4) {
                              sketch.push();
                              sketch.rotate(angle);
                              sketch.branch(len * 0.6);
                              sketch.pop();
                              sketch.push();
                              sketch.rotate(-angle);
                              sketch.branch(len * 0.6);
                              sketch.pop();
                          }
                      }
                  }

                  const p5 = require('p5');
                  number[i] = new p5(script[i], i.toString())
                  number[i].analysis = this.analysis[i];
              }
          }
        },

        mounted() {
            console.log('Playlist component mounted.');
        },

        methods: {
            exportPlaylist() {
                // const playlistId = this.$route.params.playlistId;
                //
                // window.axios.get('/api/playlists/' + playlistId + '/export').then(response => {
                //     this.playlist = response.data;
                // })

                let canvas = this.$refs.canvas0[0].childNodes[0]
                console.log(canvas);
                const dataUrl = canvas.toDataURL('image/png');
                console.log(dataUrl);
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
