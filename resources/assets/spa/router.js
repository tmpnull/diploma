import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home.vue';

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/timetable/',
            name: 'home',
            component: Home,
        },
        { path: '*', name: 'notFound', component: () => import('./views/NotFound.vue') }
    ],
});
