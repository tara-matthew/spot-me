<template>
    <div>
        <page-header />
        <v-container>
            <loading v-if="!loadImages" :loadImages="loadImages"/>
            <playlist v-if="playlist && analysis" :playlist="playlist" :isLoading="isLoading" :analysis="analysis" />

            <!--<visualise />-->
        </v-container>

    </div>
</template>

<script>

    import PageHeader from '@/js/components/Header'
    import Playlist from '@/js/components/ViewPlaylist/Playlist'
    import Loading from '@/js/components/ViewPlaylist/Loading'

    export default {
        data() {
            return {
                playlist: {},
                analysis: {},
                isLoading: true,
                loadImages: false,
            }
        },

        async mounted() {
                const playlistId = this.$route.params.playlistId;

                window.axios.get('/api/playlists/' + playlistId).then(response => {
                    this.playlist = response.data;
                    this.isLoading = false;

                }).catch(function(error) {
                    console.log('here', error)
                    window.location = '/'
                })

                window.axios.get('/api/playlists/' + playlistId + '/analyse').then(response => {
                    this.analysis = response.data;
                    this.loadImages = true;
                })


        },

        components: {
            PageHeader,
            Playlist,
            Loading
        }
    }

</script>