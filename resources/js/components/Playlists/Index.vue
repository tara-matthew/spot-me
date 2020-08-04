<template>
    <div>

        <page-header />
        <v-container>
            <playlists v-if="playlists" :playlists="playlists" />
        </v-container>

    </div>
</template>

<script>

    import PageHeader from '@/js/components/Header'
    import Playlists from '@/js/components/Playlists/Playlists'

    export default {
        data() {
            return {
                playlists: {}
            }
        },

        async mounted() {
            window.axios.get('/api/playlists').then(response => {
                this.playlists = response.data;
            })
        },

        components: {
            PageHeader,
            Playlists
        }
    }

</script>