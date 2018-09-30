import Vue from 'vue';
import { mapState } from 'vuex';

import App from './App.vue';
import router from './router';
import store from './store/index';
import acl from './acl';

Vue.config.productionTip = false;

import VueMaterial from 'vue-material';
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default.css';

Vue.use(VueMaterial);

import axios from 'axios';

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
};

new Vue({
    router,
    acl,
    store,
    render: h => h(App),
    beforeCreate() {
        this.$store.dispatch('user/getCurrentUser');
    },
    computed: mapState({
        currentUser: state => state.user.current,
    }),
    watch: {
        currentUser: function (user) {
            this.$acl.change(user.role.name);
        },
    },
}).$mount('#app');
