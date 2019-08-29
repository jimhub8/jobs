<template>
<div>
    <v-content>
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>
                <div style="width: 100%;">
                    <!-- <v-card style="background: rgba(5, 117, 230, 0.16);">
                        <v-layout wrap>
                            <v-flex xs4 sm3 offset-sm4>
                                <v-select :items="AllRoles" v-model="select" label="Select Role" single-line item-text="name" item-value="name" return-object persistent-hint></v-select>
                            </v-flex>
                            <v-flex xs4 sm3>
                                <v-btn raised color="info" @click="sort">Filter</v-btn>
                            </v-flex>
                        </v-layout>
                    </v-card> -->
                    <!-- users display -->
                    <v-card-title>
                        Users
                        <v-btn v-slot:activator="{ on }" color="primary" dark text @click="openAdd">Add User</v-btn>
                        <v-btn v-slot:activator="{ on }" color="orange" dark text @click="openDeleted">Deleted Users</v-btn>
                        <v-tooltip right>
                            <v-btn icon v-slot:activator="{ on }" class="mx-0" @click="getUsers">
                                <v-icon color="blue darken-2" small>refresh</v-icon>
                            </v-btn>
                            <span>Refresh</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line></v-text-field>
                    </v-card-title>
                    <vue-good-table class="table-hover" :columns="columns" :rows="users.data" :search-options="{ enabled: true }" :pagination-options="{enabled: true,mode: 'pages'}" :sort-options="{enabled: true, initialSortBy: {field: 'name', type: 'asc'}}" v-loading="isLoading">
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'created_at'">
                                <span>
                                    <el-tag type="success">{{props.row.created_at}}</el-tag>
                                </span>
                            </span>
                            <span v-else-if="props.column.field == 'actions'">
                                <v-tooltip bottom>
                                    <v-btn icon class="mx-0" @click="openEdit(props.row)" v-slot:activator="{ on }">
                                        <v-icon small color="blue darken-2">edit</v-icon>
                                    </v-btn>
                                    <span>Edit {{ props.row.name }}'s details</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <v-btn icon class="mx-0" @click="openShow(props.row)" v-slot:activator="{ on }">
                                        <v-icon small color="blue darken-2">visibility</v-icon>
                                    </v-btn>
                                    <span>View {{ props.row.name }}'s details</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <v-btn icon class="mx-0" @click="openPerm(props.row)" v-slot:activator="{ on }">
                                        <v-icon small color="orange darken-2">dialpad</v-icon>
                                    </v-btn>
                                    <span>Edit {{ props.row.name }}'s permissions</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <v-btn icon class="mx-0" @click="deleteItem(props.row)" v-slot:activator="{ on }">
                                        <v-icon small color="pink darken-2">delete</v-icon>
                                    </v-btn>
                                    <span>Delete {{ props.row.name }}</span>
                                </v-tooltip>
                            </span>
                            <span v-else>
                                {{props.formattedRow[props.column.field]}}
                            </span>
                        </template>
                    </vue-good-table>
                    <!-- users users -->
                </div>
            </v-layout>
        </v-container>
        <div v-show="loader" style="text-align: center; width: 100%;">
            <v-progress-circular :width="3" indeterminate color="green" style="margin: 1rem"></v-progress-circular>
        </div>
    </v-content>
    <AddUser :user="user"></AddUser>
    <EditUser></EditUser>
    <UserProfile></UserProfile>
    <PermUser></PermUser>
    <DeletedUsers></DeletedUsers>
</div>
</template>

<script>
import AddUser from "./AddUser.vue";
import PermUser from './Permission.vue';
import DeletedUsers from './DeletedUsers.vue';
import EditUser from "./EditUser.vue";
import UserProfile from "./UserProfile.vue";
export default {
    props: ["user"],
    components: {
        AddUser,
        PermUser,
        EditUser,
        UserProfile,
        DeletedUsers
    },
    data() {
        return {
            loader: false,
            search: '',
            columns: [{
                    label: "Name",
                    field: "name"
                },
                {
                    label: "Email",
                    field: "email"
                },
                {
                    label: "Address",
                    field: "address"
                },
                {
                    label: "Phone Number",
                    field: "phone"
                },
                {
                    label: "Department",
                    field: "department"
                },
                {
                    label: "Position",
                    field: "position"
                },
                {
                    label: "Status",
                    field: "status"
                },
                {
                    label: "Actions",
                    field: "actions",
                    sortable: false
                }
            ],
        };
    },
    methods: {
        openDeleted() {
            eventBus.$emit('openDeletedEvent')
        },
        openAdd() {
            eventBus.$emit('openCreateUserEvent')
        },
        openEdit(item) {
            eventBus.$emit('openEditeUserEvent', item)
        },
        openPerm(item) {
            eventBus.$emit('openPermissionEvent', item)
            this.$store.dispatch('getUserPerm', item.id)
            this.$store.dispatch('getPermissions')
        },
        openShow(item) {
            eventBus.$emit('openUserShow', item)
        },
        deleteItem(item) {
            if (confirm("Are you sure you want to delete this user?")) {
                // const index = this.users.indexOf(item)
                axios
                    .delete(`/users/${item.id}`)
                    .then(response => {
                        this.$store.dispatch('alertEvent', 'User deleted')
                        this.getUsers()
                        // this.users.splice(index, 1);
                    })
                    .catch(error => {
                        this.loading = false;
                        this.snackbar = true;
                    });
            }
        },
        getUsers() {
            this.$store.dispatch('getUsers').then(response => {
                this.loader = false
            })
        },
        getRoles() {
            this.$store.dispatch('getRoles')
        }
    },
    mounted() {
        this.loader = true;
        this.getRoles()
        this.getUsers()
    },
    computed: {
        roles() {
            return this.$store.getters.roles
        },
        users() {
            return this.$store.getters.users
        },
        isLoading() {
            return this.$store.getters.loading;
        },
    },
    // beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //         if (vm.user.can["view users"]) {
    //             next();
    //         } else {
    //             next("/unauthorized");
    //         }
    //     });
    // },

    created() {
        eventBus.$on('userEvent', data => {
            this.getUsers()
        })
    },
};
</script>

<style scoped>
.content--wrap {
    margin-top: -100px;
}

#profile {
    width: 70px;
    height: 60px;
    border-radius: 50%;
    margin-left: 80px;
    margin-top: -30px;
}

i {
    padding: 7px;
    background: #f0f0f0;
    border-radius: 50%;
}

.list-group-item:hover,
.list-group-item:focus {
    z-index: 1;
    background: #f9f9f9;
    text-decoration: none;
}
</style>
