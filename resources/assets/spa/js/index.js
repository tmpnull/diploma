import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import App from './views/App';
import Timetable from './views/Timetable';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/timetable',
            name: 'timetable',
            component: Timetable,
        },
    ],
});

const index = new Vue({
    el: '#app',
    components: { App },
    router,
});
