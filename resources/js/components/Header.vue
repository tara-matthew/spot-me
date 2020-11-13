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

            <v-btn
                class="header-button"
                text
                @click="signOut">
                Sign Out
            </v-btn>
        </v-toolbar-items>
    </v-toolbar>
</template>

<script>
    export default {
        methods: {
            signOut() {
                window.axios.post('api/signout').then(response => {
                    this.$router.push({
                        name: 'home'
                    })
                })

            }
        }
    }
</script>

<style scoped>
    a:hover {
        text-decoration: none;
    }
    .header-button {
        color: #c0d1c9;
    }
</style>