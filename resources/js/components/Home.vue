<template>
    <v-main class="fill-height fluid">
        <v-container
                fill-height
                fluid
                justify-center
        >
            <v-card class="p-3">
                <v-card-title class="justify-center display-3 mb-3">Spot Me</v-card-title>
                <p class="title">View and export your playlists, with their tracks visualised as fractal trees which represent their danceability.</p>
                <p class="font-weight-bold title">Log in to check this out!</p>
                <v-btn @click="authenticateSpotify" class="white--text rounded-xl" color="#1db954">Log in with Spotify</v-btn>
            </v-card>
        </v-container>
    </v-main>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            async authenticateSpotify() {
                const data = window.axios.get('/api/spotify/authenticate').then(response => {
                    window.location = response.data;
                })
            }
        }
    }

</script>
