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

                <v-btn @click="callSpotify">Test</v-btn>
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
            async callSpotify() {
                // window.location='https://accounts.spotify.com';
                const data = window.axios.get('/api/spotify').then(response => {
                    console.log(response)
                    window.location = response.data;
                    // console.log(response.request.responseURL)
                    // window.location = response.request.responseURL
                })
                console.log(data);
            }
        }
    }

</script>
