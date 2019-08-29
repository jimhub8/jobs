<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add User</span>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-form ref="form" @submit.prevent="submit">
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.name" color="purple darken-2" label="Full name" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.email" color="blue darken-2" label="Email" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.address" color="blue darken-2" label="Address" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.department" color="blue darken-2" label="Department" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.department">{{ errors.department[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.position" color="blue darken-2" label="position" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.position">{{ errors.position[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.phone" color="blue darken-2" label="Phone" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                                    </v-flex>

                                    <div class="form-group col-md-6">
                                        <label class="col-md-6 col-form-label text-md-right" for="">Role</label>
                                        <select class="custom-select custom-select-md col-md-12" v-for="role in form.roles" :key="role.id" v-model="role.name">
                                            <option v-for="roles in roles" :key="roles.id" :value="roles.name">{{ roles.name }}</option>
                                        </select>
                                    </div>
                                </v-layout>
                            </v-container>
                            <v-card-actions>
                                <v-btn text @click="resetForm">reset</v-btn>
                                <v-btn text @click="close">Close</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="loading" text color="primary" @click="update" :loading="loading">Submit</v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-layout>
                </v-container>
            </v-card-text>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data() {
        return {
            dialog: false,
            loading: false,
            form: {},
            errors: [],
            selected: [],
            permissions: [],
        }
    },
    methods: {
        update() {
            this.loading = true
            axios.patch(`/users/${this.form.id}`, this.form).
            then((response) => {
                    // console.log(response);
                    this.loading = false
                    eventBus.$emit('alertRequest', 'User updated');
                    this.close();
                    this.$store.dispatch('getUsers')
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                    this.loading = false
                })
        },
        resetForm() {
            this.form = Object.assign({}, this.defaultForm)
            this.$refs.form.reset()
        },
        close() {
            this.dialog = false
        },
    },
    created() {
        eventBus.$on('permEvent', data => {
            this.selected = data;
        });
        eventBus.$on('openEditeUserEvent', data => {
            this.dialog = true
            this.form = data
        });
    },
    computed: {
        formIsValid() {
            return (
                this.form.name &&
                this.form.email &&
                this.form.phone &&
                this.form.password &&
                this.form.branch &&
                this.form.address &&
                this.form.city &&
                this.form.country
            )
        },
        roles() {
            return this.$store.getters.roles
        },
    },
    mounted() {

        axios.get('/getPermissions')
            .then((response) => {
                this.permissions = response.data
            })
            .catch((errors) => {
                this.errors = error.response.data.errors
            })
    }
}
</script>
