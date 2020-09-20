<template>
    <v-container v-if="!loadImages">
        <h1>Loading...</h1>
    </v-container>
</template>

<script>

    export default {
        props: [
            'loadImages',
        ]
    }
</script>