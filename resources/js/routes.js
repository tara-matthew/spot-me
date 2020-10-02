import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '@/js/components/Home';
import About from '@/js/components/About';
import Playlists from '@/js/components/Playlists/Index';
import Playlist from '@/js/components/ViewPlaylist/Index';
import Key from '@/js/components/Key';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/about',
            name: 'about',
            component: About
        },
        {
            path: '/playlists',
            name: 'playlists',
            component: Playlists
        },
        {
            path: '/playlists/:playlistId',
            name: 'viewPlaylist',
            component: Playlist
        },
        {
            path: '/key',
            name: 'key',
            component: Key
        }
    ]
})

export default router;