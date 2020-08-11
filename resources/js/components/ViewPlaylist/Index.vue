<template>
    <div>
        <page-header />
        <v-container>
            <playlist v-if="playlist && analysis" :playlist="playlist" :isLoading="isLoading" :analysis="analysis" />
            <!--<visualise />-->
        </v-container>

    </div>
</template>

<script>

    import PageHeader from '@/js/components/Header'
    import Playlist from '@/js/components/ViewPlaylist/Playlist'
    import Visualise from '@/js/components/ViewPlaylist/Visualise'

    export default {
        data() {
            return {
                playlist: {},
                analysis: {},
                isLoading: true,
                p5Loaded: false
            }
        },

        async mounted() {
            const playlistId = this.$route.params.playlistId;

            window.axios.get('/api/playlists/' + playlistId).then(response => {
                this.playlist = response.data;
                this.isLoading = false;
                // console.log(this.playlist);

            })

            window.axios.get('/api/playlists/' + playlistId + '/analyse').then(response => {
                this.analysis = response.data;
                console.log('here', this.analysis);
            })

        },

        components: {
            PageHeader,
            Playlist,
            Visualise
        }
    }

</script>