/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue';

import Vuetify from 'vuetify';
import Routes from '@/js/routes.js';


Vue.use(Vuetify);
const vuetify = new Vuetify();

import App from '@/js/views/App';

const app = new Vue({
    el: '#app',
    router: Routes,
    vuetify,
    render: h => h(App),
});

export default app;
