export default {
    loading(state, payload) {
        state.loading = payload
    },
    error(state, payload) {
        state.error = payload
    },
    updateClientList(state, payload) {
        state.clients = payload
    },
    updateClientSearchList(state, payload) {
        state.seachClient = payload
    },
    alertEvent(state, payload) {
        state.alertEvent = payload
    },
    updateUsersList(state, payload) {
        state.users = payload
    },
    updateRoleList(state, payload) {
        state.roles = payload
    },
    updateStatusList(state, payload) {
        state.status = payload
    },
    updatPracticeList(state, payload) {
        state.practice_area = payload
    },
    updatJobsList(state, payload) {
        state.jobs = payload
    },
    updatLeadsList(state, payload) {
        state.leads = payload
    },
    updateUserPermList(state, payload) {
        state.user_perm = payload
    },
    updatePermList(state, payload) {
        state.permissions = payload
    },


    // Notifications
    updatenotifications(state, payload) {
        state.notifications = payload
    },
}
