<template>
    <v-toolbar color="#7a2ec7">
        <v-toolbar-title class="white--text">
            <router-link
                    to="/playlists"
                    style="cursor:pointer"
                    tag="span"
            >
            Spot Me
            </router-link>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
            <v-btn
                class="header-button"
                text
                :to="{
                    name: 'key'
                }">
            Key
            </v-btn>
        </v-toolbar-items>
    </v-toolbar>
</template>

<style scoped>
    a:hover {
        text-decoration: none;
    }
    .header-button {
        color: #c0d1c9;
    }
</style>