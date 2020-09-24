<template>
    <v-container v-if="!loadImages">
        <h1 class="loading">Loading</h1>
    </v-container>
</template>

<script>

    export default {
        props: [
            'loadImages',
        ]
    }
    
</script>

<style scoped>
    .loading:after {
        content: '.';
        animation: dots 1s steps(5, end) infinite;}

    @keyframes dots {
        0%, 20% {
            color: rgba(0,0,0,0);
            text-shadow:
                    .25em 0 0 rgba(0,0,0,0),
                    .5em 0 0 rgba(0,0,0,0);
        }

        40% {
            color: white;
            text-shadow:
                    .25em 0 0 rgba(0,0,0,0),
                    .5em 0 0 rgba(0,0,0,0);
        }

        60% {
            text-shadow:
                    .25em 0 0 white,
                    .5em 0 0 rgba(0,0,0,0);
        }

        80%, 100% {
            text-shadow:
                    .25em 0 0 white,
                    .5em 0 0 white;
        }
    }

</style>