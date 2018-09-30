import axios from 'axios';

export default {
    async getCourses(cb) {
        const response = await axios.get('/api/audiences');
        cb(response.data);
    },
};
