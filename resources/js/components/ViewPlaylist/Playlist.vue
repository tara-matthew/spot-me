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

              for (var i = 0; i < playlistLength - 1; i++ ) {
                  script[i] = function (sketch) {
                      sketch.setup = _ => {
                          sketch.createCanvas(100, 100)
                      }
                      sketch.draw = _ => {
                          sketch.background(sketch.analysis['tempo'])
                      }
                  }

                  const p5 = require('p5');
                  number[i] = new p5(script[i], i.toString())
                  number[i].analysis = this.analysis[i];
                  // console.log(number[0]);
              }
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
