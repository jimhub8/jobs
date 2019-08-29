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
                    <v-data-table :headers="headers" :items="users.data" class="elevation-1" :loading="isLoading" :search="search">
                        <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                        <template slot="items" slot-scope="props">
                            <td>{{ props.item.name }}</td>
                            <td class="text-xs-right">{{ props.item.email }}</td>
                            <td class="text-xs-right">{{ props.item.address }}</td>
                            <td class="text-xs-right">{{ props.item.phone }}</td>
                            <td class="text-xs-right">{{ props.item.department }}</td>
                            <td class="text-xs-right">{{ props.item.position }}</td>
                            <td class="text-xs-right">{{ props.item.status }}</td>
                            <td class="justify-center layout px-0">
                                <v-tooltip bottom>
                                    <v-btn icon class="mx-0" @click="openEdit(props.item)" v-slot:activator="{ on }">
                                        <v-icon small color="blue darken-2">edit</v-icon>
                                    </v-btn>
                                    <span>Edit</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <v-btn icon class="mx-0" @click="openShow(props.item)" v-slot:activator="{ on }">
                                        <v-icon small color="blue darken-2">visibility</v-icon>
                                    </v-btn>
                                    <span>View user</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <v-btn icon class="mx-0" @click="openPerm(props.item)" v-slot:activator="{ on }">
                                        <v-icon small color="orange darken-2">dialpad</v-icon>
                                    </v-btn>
                                    <span>Edit Permissions</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <v-btn icon class="mx-0" @click="deleteItem(props.item)" v-slot:activator="{ on }">
                                        <v-icon small color="pink darken-2">delete</v-icon>
                                    </v-btn>
                                    <span>Delete</span>
                                </v-tooltip>
                            </td>
                        </template>
                        <v-alert slot="no-results" :value="true" color="error" icon="warning">
                            Your search for "{{ search }}" found no results.
                        </v-alert>
                    </v-data-table>
                    <!-- users display -->
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
            headers: [{
                    text: "Name",
                    value: "name"
                },
                {
                    text: "Email",
                    value: "email"
                },
                {
                    text: "Address",
                    value: "address"
                },
                {
                    text: "Phone Number",
                    value: "phone"
                },
                {
                    text: "Department",
                    value: "department"
                },
                {
                    text: "Position",
                    value: "position"
                },
                {
                    text: "Status",
                    value: "status"
                },
                {
                    text: "Actions",
                    value: "name",
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
        },
        openShow(item) {
            this.editedIndex = this.users.indexOf(item);
            this.editedItem = Object.assign({}, item);
            eventBus.$emit("getShipEvent", this.editedItem);

            this.dispShow = true;
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
