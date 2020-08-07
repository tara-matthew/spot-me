<template>
    <div>
        <page-header />
        <v-container>
            <playlist v-if="playlist" :playlist="playlist" :isLoading="isLoading" />
        </v-container>

    </div>
</template>

<script>

    import PageHeader from '@/js/components/Header'
    import Playlist from '@/js/components/ViewPlaylist/Playlist'

    export default {
        data() {
            return {
                playlist: {},
                isLoading: true
            }
        },

        async mounted() {
            const playlistId = this.$route.params.playlistId;

            window.axios.get('/api/playlists/' + playlistId).then(response => {
                this.playlist = response.data;
                this.isLoading = false;
            })
        },

        components: {
            PageHeader,
            Playlist
        }
    }

</script>