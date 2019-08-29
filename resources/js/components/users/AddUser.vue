<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px" v-if="dialog">
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
                        <v-form ref="form" @submit.prevent>
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
                                        <select class="custom-select custom-select-md col-md-12" v-model="form.role_id">
                                            <option v-for="roles in roles" :key="roles.id" :value="roles.name">{{ roles.name }}</option>
                                        </select>
                                        <small class="has-text-danger" v-if="errors.role_id">{{ errors.role_id[0] }}</small>
                                    </div>
                                    <div class="form-group col-md-6" v-for="role in user.roles" :key="role.id" v-if="role.name == 'Super admin'">
                                         <label for="">Firm</label>
                                        <el-select v-model="form.firm_id" clearable placeholder="Firm" style="width: 100%;">
                                            <el-option v-for="item in firms" :key="item.id" :label="item.name" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </v-layout>
                            </v-container>
                            <v-card-actions>
                                <v-btn text @click="resetForm">reset</v-btn>
                                <v-btn text @click="close">Close</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="loading" text color="primary" @click="save" :loading="loading">Submit</v-btn>
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
    props: ['user'],
    data() {
        const defaultForm = Object.freeze({
            name: "",
            email: "",
            phone: "",
            address: "",
            department: "",
            position: "",
        });
        return {
            loading: false,
            errors: [],
            selected: [],
            permissions: [],
            defaultForm,
            dialog: false,
            form: Object.assign({}, defaultForm),
        };
    },
    methods: {
        save() {
            this.loading = true;
            axios
                .post("/users", this.$data.form)
                .then(response => {
                    // alert('error1')
                    this.loading = false;
                    // console.log(response);
                    // this.resetForm();
                    eventBus.$emit('alertRequest', 'User added');
                    // this.close();
                    this.$store.dispatch('getUsers')
                })
                .catch(error => {
                    // alert('error2')
                    this.loading = false;
                    if (error.response.status === 500) {
                        eventBus.$emit('errorEvent', error.response.statusText)
                        return
                    }
                    this.errors = error.response.data.errors
                    console.log(error);
                    this.errors = error.response.data.errors;
                });
        },
        resetForm() {
            this.form = Object.assign({}, this.defaultForm);
            this.$refs.form.reset();
        },
        close() {
            this.dialog = false
        },

        getFirms() {
            this.$store.dispatch('getFirms');
        },
    },
    mounted() {
        axios
            .post("/getCompanyAdmin")
            .then(response => {
                this.Allusers = response.data;
            })
            .catch(error => {
                this.errors = error.response.data.errors;
            });

        axios
            .get("/getPermissions")
            .then(response => {
                console.log(response.data);
                this.permissions = response.data;
            })
            .catch(errors => {
                this.errors = error.response.data.errors;
            });
    },
    created() {
        eventBus.$on('openCreateUserEvent', data => {
            this.dialog = true
            this.getFirms()
        });
    },

    computed: {
        roles() {
            return this.$store.getters.roles
        },
        firms() {
            return this.$store.getters.firms
        },
    },
    mounted() {}
};
</script>
