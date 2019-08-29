<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Edit Role</span>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="dialog = false">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 sm12>
                            <v-text-field v-model="form.name" color="blue darken-2" label="Role" required></v-text-field>
                            <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                        </v-flex>
                        <v-checkbox v-model="selectAll" label="Select All" value="all" @change="selectRoles"></v-checkbox>

                        <v-layout wrap>
                            <v-flex v-for="(perm, index) in permissions" :key="index" xs6 sm3>
                                <v-checkbox v-model="selected" :label="perm.name" :value="perm.name"></v-checkbox>
                            </v-flex>
                        </v-layout>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-btn text @click="resetForm">reset</v-btn>
                    <v-btn text @click="dialog = false">Close</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn :disabled="loading" text color="primary" @click="save" :loading="loading">Submit</v-btn>
                </v-card-actions>
            </v-card-text>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data() {
        return {
            selectAll: [],
            form: {},
            loading: false,
            dialog: false,
            selected: [],
        };
    },
    methods: {
        save() {
            this.loading = true;
            axios
                .patch(`/roles/${this.form.id}`, {
                    form: this.form,
                    selected: this.selected
                })
                .then(response => {
                    this.loading = false;
                    this.$store.dispatch('getRoles')
                    eventBus.$emit('alertRequest', 'Role updated')
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
        resetForm() {
            this.form = Object.assign({}, this.defaultForm);
            this.$refs.form.reset();
        },
        close() {
            this.dialog = true
        },
        selectRoles() {
            this.selected = [];
            // console.log(sel)
            this.selectAll.forEach(sel => {
                this.permissions.forEach(perm => {
                    this.selected.push(perm.name);
                });
            });
            // console.log(this.selectAll)
        },
        getRolesPerm(data) {
        axios.post(`/getRolesPerm/${data.id}`, data).then((response) => {
            this.selected = response.data
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

    },
    created() {
        eventBus.$on("openEditRoleEvent", data => {
            this.dialog = true;
            this.form = data
            this.getRolesPerm(data)
        });
    },
    computed: {
        permissions() {
            return this.$store.getters.permissions
        },
        // sortPerm() {
        //     return _.orderBy(this.permissions, 'name', 'asc')
        // }
    },
};
</script>
