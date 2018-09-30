import axios from 'axios';

export default {
    async getTimetable(cb) {
        const response = await axios.get('/api/timetables');
        cb(response.data);
    },

    async storeTimetable(params, cb) {
        let response = {};
        try {
            response = await axios.post('/api/timetables', params);
            cb({ data: response.data });
        } catch (e) {
            cb({ error: e.response.data });
        }
    },

    async getByGroupWithParams(params, cb) {
        let baseQuery = `/api/timetables/group/${params.id}`;

        Object.keys(params.query).forEach((key, index) => {
            if (index === 0) {
                baseQuery = `${baseQuery}?${key}=${params.query[key]}`;
            } else {
                baseQuery = `${baseQuery}&${key}=${params.query[key]}`;
            }
        });

        const response = await axios.get(baseQuery);
        cb(response.data);
    },
};
