import axios from 'axios';

export default {
    async getCourses(cb) {
        const response = await axios.get('/api/courses');
        cb(response.data);
    },
};
