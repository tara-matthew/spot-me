<template>
    <v-container v-if="!isLoading">
        <v-row justify="center">
            <v-col cols="6" >
                <h1> {{ playlist.info.playlistTitle }}</h1>
                <v-btn @click="exportPlaylist">Export this playlist</v-btn>
                <v-card>

                    <v-list two-line>
                        <template v-for="(track, index) in playlist.tracks">
                            <v-row>
                                <v-col>
                                    <v-subheader>
                                        {{ track.name }}
                                    </v-subheader>
                                    <v-list-item>
                                        {{ track.artist }}
                                    </v-list-item>
                                </v-col>
                                <v-col>
                                    <div class="d-flex justify-center":id="index" :ref="'canvas' + index"></div>
                                </v-col>
                            </v-row>
                            <v-divider></v-divider>
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
              const playlistLength = Object.keys(this.playlist.tracks).length;
              let script = [];
              let number = [];

              for (var i = 0; i < playlistLength; i++ ) {
                  script[i] = function (sketch) {
                      let angle = 0;
                      sketch.setup = _ => {
                          sketch.angleMode(sketch.DEGREES);
                          sketch.createCanvas(100, 100)
                      }
                      sketch.draw = _ => {
                          sketch.noLoop()
                          sketch.background(sketch.analysis['tempo']);
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
                const playlistId = this.$route.params.playlistId;
                let canvases = [];
                let dataUrls = [];

                for (let ref in this.$refs) {
                    canvases.push(this.$refs[ref][0].childNodes[0]);
                }

                canvases.forEach(function(item, index) {
                    dataUrls.push(item.toDataURL('image/png'));
                })

                window.axios.post('/api/playlists/' + playlistId + '/export', {
                    headers: {
                        contentType: 'application/pdf'
                    },
                    dataUrls: dataUrls,
                }, {
                    responseType: 'arraybuffer'
                }).then(response => {
                    let blob = new Blob([response.data], {type: 'application/pdf'})
                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = this.playlist.info.playlistTitle;
                    link.click();
                })
            },
        },

        components: {
            Visualise
        }
    }
</script>
