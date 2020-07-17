<template>

    <v-container>
        <v-card
            class="mx-auto"
            max-width="344"
            outlined>
            <v-card-title class="justify-center"><h1>Authenticate!</h1></v-card-title>
        </v-card>

        <div>
            <v-btn
                @click="authenticateSpotify">
                Authenticate me please
            </v-btn>
        </div>
    </v-container>

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
