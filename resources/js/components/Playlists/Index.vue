<template>
    <div>

        <page-header />
        <v-container>
            <playlists v-if="playlists" :playlists="playlists" />
        </v-container>

    </div>
</template>

<script>

    import PageHeader from '@/js/components/Header';
    import Playlists from '@/js/components/Playlists/Playlists';
    import Key from '@/js/components/Key';

    export default {
        data() {
            return {
                playlists: {}
            }
        },

        async mounted() {
            window.axios.get('/api/playlists').then(response => {
                this.playlists = response.data;
            }).catch(function(error) {
                console.log(error);
                window.location = '/'
            })
        },

        components: {
            PageHeader,
            Playlists,
            Key
        }
    }

</script>