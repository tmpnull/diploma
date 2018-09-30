import Vue from 'vue';
import Router from 'vue-router';

import Home from './views/Home.vue';
import Edit from './views/Edit.vue';

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/timetable/',
            name: 'home',
            component: Home,
            meta: {
                rule: ['*'],
            },
            props: {
                pageTitle: 'Расписание',
            },
        },
        {
            path: '/timetable/edit',
            name: 'edit',
            component: Edit,
            meta: {
                rule: 'isManager',
            },
            props: {
                pageTitle: 'Редактор расписания',
            },
        },
        {
            path: '*',
            name: 'notFound',
            component: () => import('./views/NotFound.vue'),
            meta: {
                rule: ['*'],
            },
            props: {
                pageTitle: '404',
            },
        },
    ],
});
