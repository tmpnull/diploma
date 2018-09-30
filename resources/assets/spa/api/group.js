import axios from 'axios';

export default {
    async getGroups(cb) {
        const response = await axios.get('/api/groups');
        cb(response.data);
    },
};
