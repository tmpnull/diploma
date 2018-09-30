import Vue from 'vue';
import { AclInstaller, AclCreate, AclRule } from 'vue-acl';
import router from './router';

Vue.use(AclInstaller);

const initRole = sessionStorage.getItem('role');

export default new AclCreate({
    notfound: '/timetable/',
    initial: initRole ? initRole : '*',
    router,
    acceptLocalRules: true,
    globalRules: {
        isSuperAdmin: new AclRule('superadmin').generate(),
        isAdmin: new AclRule('admin').generate(),
        isManager: new AclRule('manager').or('superadmin').or('manager').generate(),
        isTeacher: new AclRule('teacher').generate(),
        isStudent: new AclRule('student').generate(),
    },
});
