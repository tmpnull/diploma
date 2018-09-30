import axios from 'axios';

export default {
    async getCurrentUser(cb) {
        const response = await axios.get('/api/user');
        sessionStorage.setItem('role', response.data.role.name);
        cb(response.data);
    },

    async getPhoto(cb) {
        const response = await axios.get('/api/user');
        cb(response.data);
    },
};
