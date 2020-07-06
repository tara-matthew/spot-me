import Vue from 'vue';
import VueRouter from 'vue-router';
console.log(VueRouter);
import Home from '@/js/components/Home';
import About from '@/js/components/About';


Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/home',
            name: 'home',
            component: Home
        },
        {
            path: '/about',
            name: 'about',
            component: About
        }
    ]
})

export default router;