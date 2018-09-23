import axios from 'axios';

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
};

export default {
    async getTimetable(cb) {
        const response = await axios.get('/api/timetables');
        cb(response.data);
    },

    async getByGroupWithDate(params, cb) {
        const response = await axios.get(`/api/timetables/group/${params.id}?date=${params.date}`);
        cb(response.data);
    },
};
