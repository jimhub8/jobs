export default {
    loading(state) {
        return state.loading;
    },
    error(state) {
        return state.error;
    },
    alertEvent(state) {
        eventBus.$emit('alertEvent', state)
        // return state.alertEvent;
    },
    users(state) {
        return state.users
    },
    clients(state) {
        return state.clients;
    },
    roles(state) {
        return state.roles
    },
    seachClient(state) {
        return state.seachClient;
    },
    status(state) {
        return state.status;
    },
    practice_area(state) {
        return state.practice_area;
    },
    jobs(state) {
        return state.jobs;
    },
    leads(state) {
        return state.leads;
    },
    user_perm(state) {
        return state.user_perm;
    },
    permissions(state) {
        // return state.permissions;
        return _.orderBy(state.permissions, 'name', 'asc')
    },

    // Notifications
    notifications(state) {
        return state.notifications;
    },
}
