<template>
    <div>
        <page-header />
        <v-container>
            <loading v-if="!loadImages" :loadImages="loadImages" :text="text"/>
            <loading v-if="exporting" :text="text"></loading>
            <playlist v-if="playlist && analysis" @isExporting="isExporting" :playlist="playlist" :isLoading="isLoading" :analysis="analysis" :exporting="exporting" />
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
                exporting: false,
                text: 'Loading'
            }
        },

        async mounted() {
            window.scrollTo(0,0);
            const playlistId = this.$route.params.playlistId;

            window.axios.get('/api/playlists/' + playlistId).then(response => {
                this.playlist = response.data;
                this.isLoading = false;
                return window.axios.get('/api/playlists/' + playlistId + '/analyse').then(response => {
                    this.analysis = response.data;
                    this.loadImages = true;
                })
            }).catch(function(error) {
                window.location = '/'
            })
        },

        methods: {
            isExporting(exporting) {
                this.exporting = exporting;
                this.text = (this.exporting ? 'Exporting' : 'Loading');
            },
        },

        components: {
            PageHeader,
            Playlist,
            Loading
        }
    }

</script>