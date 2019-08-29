import axios from "axios";
export default {
    alertEvent(context, payload) {
        eventBus.$emit('alertRequest', payload)
        // context.commit('alertEvent', payload)
    },

    errorEvent(context, payload) {
        eventBus.$emit('errorEvent', payload)
        // context.commit('alertEvent', payload)
    },

    // GET
    getUsers(context) {
        context.commit('loading', true)
        axios.get('users').then((response) => {
            context.commit('updateUsersList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },
    getUserPerm(context, payload) {
        context.commit('loading', true)
        axios.post(`/getUserPerm/${payload}`).then((response) => {
            context.commit('updateUserPermList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },

    getPermissions(context, payload) {
        context.commit('loading', true)
        axios.get('/getPermissions').then((response) => {
            context.commit('updatePermList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },

    getClients(context) {
        context.commit('loading', true)
        axios.get('clients').then((response) => {
            context.commit('updateClientList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },
    searchClient(context, payload) {
        // console.log(payload);
        context.commit('loading', true)
        axios.get(`searchClient/${payload}`).then((response) => {
            context.commit('updateClientSearchList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },
    getRoles(context) {
        context.commit('loading', true)
        axios.get('roles').then((response) => {
            context.commit('updateRoleList', response.data)
            context.commit('loading', false)
        }).catch((error) => {
            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },

    getStatus(context) {
        context.commit('loading', true)
        axios.get('status').then((response) => {
            context.commit('updateStatusList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },
    getLeads(context) {
        context.commit('loading', true)
        axios.get('leads').then((response) => {
            context.commit('updatLeadsList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },
    getJobs(context) {
        context.commit('loading', true)
        axios.get('jobs_type').then((response) => {
            context.commit('updatJobsList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },
    task_events(context) {
        context.commit('loading', true)
        axios.get('task_events').then((response) => {
            context.commit('updatTaskEventList', response.data)
            context.commit('loading', false)
        }).catch((error) => {

            if (error.response.status === 500) {
                eventBus.$emit('errorEvent', error.response.statusText)
                return
            } else if (error.response.status === 401 || error.response.status === 409) {
                eventBus.$emit('reloadRequest', error.response.statusText)
            }
            context.commit('loading', false)
            this.errors = error.response.data.errors
        })
    },

}
