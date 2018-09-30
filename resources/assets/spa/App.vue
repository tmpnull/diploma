<template>
    <md-app id="app" md-mode="reveal">
        <md-app-toolbar class="md-primary">
            <div class="md-toolbar-section-start">
                <md-button class="md-icon-button" @click="menuVisible = !menuVisible">
                    <md-icon>menu</md-icon>
                </md-button>

                <span class="md-title">{{title}}</span>
            </div>

            <div class="md-toolbar-section-end">
                <span>{{currentUser.name}} {{currentUser.surname}}</span>

                <md-menu md-direction="bottom-end">
                    <md-button md-menu-trigger class="md-icon-button">
                        <md-icon>more_vert</md-icon>
                    </md-button>

                    <md-menu-content>
                        <md-menu-item>
                            <md-button v-on:click="logout">
                                <md-icon>exit_to_app</md-icon>
                                <span>Выйти</span>
                            </md-button>
                        </md-menu-item>
                    </md-menu-content>
                </md-menu>
            </div>
        </md-app-toolbar>

        <md-app-drawer :md-active.sync="menuVisible">
            <md-toolbar class="md-transparent" md-elevation="0">Навигация</md-toolbar>

            <md-list>
                <md-list-item v-if="$acl.check('isManager')">
                    <md-icon>edit</md-icon>
                    <router-link class="md-list-item-text" to="/timetable/edit">Редактор расписания</router-link>
                </md-list-item>

                <md-list-item>
                    <md-icon>list</md-icon>
                    <router-link class="md-list-item-text" to="/timetable/">Расписание</router-link>
                </md-list-item>

                <md-list-item>
                    <md-icon>home</md-icon>
                    <a class="md-list-item-text" href="/">Домой</a>
                </md-list-item>
            </md-list>
        </md-app-drawer>

        <md-app-content>
            <router-view />
        </md-app-content>
    </md-app>
</template>

<script>
    import { mapState } from 'vuex';

    import axios from 'axios';

    export default {
        name: 'App',
        data: () => ({
            menuVisible: false,
        }),
        computed: {
            title() {
                const matchedRoute = this.$route.matched[0];
                return matchedRoute ? matchedRoute.props.default.pageTitle : '404';
            },
            ...mapState({
                currentUser: state => state.user.current,
            }),
        },
        methods: {
            logout: async function () {
                await axios.post('/logout', {});
                window.location.href = '/';
            },
        },
    };
</script>

<style lang="scss" scoped>
    #app {
        min-height: 100vh;
    }
</style>
