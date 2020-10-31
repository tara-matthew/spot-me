<template>
    <v-main class="fill-height fluid">
        <v-container
                fill-height
                fluid
                justify-center
        >
            <v-card class="p-3">
                <v-card-title class="justify-center display-3 mb-3">Spot Me</v-card-title>
                <p class="title">Do you like to dance? Do you like fractals and trees and nature?</p>
                <p class="title">You've come to the right place!</p>
                <p class="font-weight-bold title">Log in to check out how danceable the tracks on your playlists are, through the medium of fractal trees.</p>
                <v-btn @click="authenticateSpotify" class="white--text rounded-xl" color="#1db954">Log in with Spotify</v-btn>
            </v-card>
        </v-container>
    </v-main>

</template>

<script>
    export default {
        mounted() {
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
