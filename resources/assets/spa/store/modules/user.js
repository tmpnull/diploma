import user from '@/api/user';

// initial state
const state = {
    current: {},
};

// getters
const getters = {};

// actions
const actions = {
    getCurrentUser({ commit }) {
        user.getCurrentUser(userInfo => {
            commit('setUserInfo', userInfo);
        });
    },
};

// mutations
const mutations = {
    setUserInfo(state, userInfo) {
        state.current = userInfo;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
