import timetable from '@/api/timetable';
import group from '@/api/group';
import course from '@/api/course';
import audience from '@/api/audience';

// initial state
const state = {
    status: {
        sending: false,
        success: null,
        error: null,
    },
    timetable: [],
    groups: [],
    courses: [],
    audiences: [],
};

// getters
const getters = {};

// actions
const actions = {
    getTimetable({ commit }) {
        timetable.getTimetable(timetable => {
            commit('setTimetable', timetable);
            commit('setGroups', timetable.map(elem => elem[0].group));
        });
    },
    getByGroupWithParams({ commit }, payload) {
        timetable.getByGroupWithParams(payload, timetable => {
            commit('setTimetable', timetable.length > 0 ? [timetable] : []);
        });
    },
    getGroups({ commit }) {
        group.getGroups(groups => {
            commit('setGroups', groups);
        });
    },
    getCourses({ commit }) {
        course.getCourses(courses => {
            commit('setCourses', courses);
        });
    },
    getAudiences({ commit }) {
        audience.getCourses(audiences => {
            commit('setAudiences', audiences);
        });
    },
    storeTimetable({ commit }, payload) {
        commit('startSending');

        timetable.storeTimetable(payload, response => {
            if (response.error) {
                commit('setError', response.error);
            } else {
                commit('setSuccess', response.data);
            }
        });

        commit('stopSending');
    },

};

// mutations
const mutations = {
    setTimetable(state, timetable) {
        state.timetable = timetable;
    },
    setGroups(state, groups) {
        state.groups = groups;
    },
    setCourses(state, courses) {
        state.courses = courses;
    },
    setAudiences(state, audiences) {
        state.audiences = audiences;
    },
    startSending(state) {
        state.status.sending = true;
    },
    stopSending(state) {
        state.status.sending = false;
    },
    setError(state, error) {
        state.status.error = error;
        state.status.success = false;
    },
    setSuccess(state, response) {
        state.status.error = false;
        state.status.success = response;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
