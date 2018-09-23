import axios from 'axios';

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
};

export default {
    async getCurrentUser(cb) {
        const response = await axios.get('/api/user');
        cb(response.data);
    },

    async getPhoto(cb) {
        const response = await axios.get('/api/user');
        cb(response.data);
    },
};
