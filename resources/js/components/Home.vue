<template>
    <v-container>
        <v-row>
            <v-col
                cols="12">
                <v-card
                    class="mt-5">
                    <v-card-title>Home Component</v-card-title>

                    <v-card-text>
                        I'm an example component.
                    </v-card-text>
                </v-card>

                <v-btn @click="authenticateSpotify">Test</v-btn>
            </v-col>
        </v-row>
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
