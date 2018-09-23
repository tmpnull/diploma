import timetable from '@/api/timetable';

// initial state
const state = {
    timetable: [],
    groups: [],
};

// getters
const getters = {};

// actions
const actions = {
    getTimetable({ commit }) {
        timetable.getTimetable(timetable => {
            commit('setTimetable', timetable);
            commit('setGroups', timetable);
        });
    },
    getByGroupWithDate({ commit }, payload) {
        timetable.getByGroupWithDate(payload, timetable => {
            commit('setTimetable', timetable.length > 0 ? [timetable]: []);
        });
    },
};

// mutations
const mutations = {
    setTimetable(state, timetable) {
        state.timetable = timetable;
    },
    setGroups(state, timetable) {
        state.groups = timetable.map(elem => elem[0].group);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
