import actions from './actions';
import getters from './getters';
import mutations from './mutations';

export default {
    state: {
        loading: false,
        error: null,
        users: [],
        seachClient: [],
        clients: [],
        roles: [],
        leads: [],
        status: [],
        practice_area: [],
        user_perm: [],
        case_stage: [],
        jobs: [],
        permissions: [],
        // Notifications
        notifications: [],
    },
    getters,
    mutations,
    actions
}
