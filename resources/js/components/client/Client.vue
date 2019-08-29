<template>
<div>
    <v-content>
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>
                <div class="container">
                    <v-card>

                        <h3 class="text-center">Clients</h3>
                        <v-divider></v-divider>
                        <v-card-title>
                            <!-- <v-tooltip right>
                                <v-btn icon v-slot:activator="{ on }" class="mx-0" @click="getClients">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                                <span>Refresh</span>
                            </v-tooltip> -->
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" @click="getClients" color="primary">
                                        <v-icon color="grey lighten-1">refresh</v-icon>
                                    </v-btn>
                                </template>
                                <span>Refresh</span>
                            </v-tooltip>
                            <v-spacer></v-spacer>
                            <v-btn text class="mt-12" colo="primary" @click="openCreate">Add Client</v-btn>

                            <!-- <v-btn text colo="primary" @click="openEdit(selected)">Edit</v-btn> -->
                        </v-card-title>
                        <vue-good-table class="table-hover" :columns="columns" :rows="clients.data" :search-options="{ enabled: true }" :pagination-options="{enabled: true,mode: 'pages'}" :sort-options="{enabled: true, initialSortBy: {field: 'name', type: 'asc'}}" v-loading="isLoading">
                            <template slot="table-row" slot-scope="props">

                                <span v-if="props.column.field == 'created_at'">
                                    <span>
                                        <el-tag type="success">{{props.row.created_at}}</el-tag>
                                    </span>
                                </span>
                                <span v-else-if="props.column.field == 'actions'">
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" @click="openEdit(props.row)" color="primary">
                                                <v-icon color="grey lighten-1" small>edit</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>Edit</span>
                                    </v-tooltip>
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on }">
                                            <v-btn icon v-on="on" @click="deleteItem(props.row)" color="primary">
                                                <v-icon color="grey lighten-1" small>delete</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>delete</span>
                                    </v-tooltip>
                                </span>
                                <span v-else>
                                    {{props.formattedRow[props.column.field]}}
                                </span>
                            </template>
                        </vue-good-table>
                    </v-card>
                </div>
            </v-layout>
        </v-container>
    </v-content>
    <Create></Create>
    <Edit></Edit>
    <!-- <Show></Show> -->
</div>
</template>

<script>
import Create from './Create';
import Edit from './Edit';
// import Show from './Show';
export default {
    components: {
        Create,
        Edit,
        // Show
    },
    data() {
        return {
            loading: false,
            isEmpty: false,
            loader: false,
            search: '',
            selected: [],

            columns: [{
                    label: 'Id#',
                    field: 'client_id',
                    type: 'number',
                },
                {
                    label: 'Client name',
                    field: 'name',
                },
                {
                    label: 'Email',
                    field: 'email',
                },
                {
                    label: 'Contact person',
                    field: 'contact_person',
                },
                {
                    label: 'Contact person phone',
                    field: 'contact_person',
                },
                // {
                //     label: 'Created On',
                //     field: 'created_at',
                //     type: 'date',
                // },
                {
                    label: 'Actions',
                    field: 'actions',
                },
            ],
            isPaginated: true,
            currentPage: 1,
            perPage: 5,
            items: ['Activate Box', 'Deactivate Box', 'Delete Box'],
        }
    },
    methods: {
        openCreate() {
            eventBus.$emit('openCreateBox')
        },

        openEdit(data) {
            eventBus.$emit('openEditBox', data)
        },

        openShow(data) {
            eventBus.$emit('openShowBox', data)
        },
        getClients() {
            eventBus.$emit("LoadingEvent");
            this.$store.dispatch('getClients');
        },
        deleteItem(item) {
            console.log(item)
            const index = this.$store.getters.clients.indexOf(item);
            if (confirm("Are you sure you want to delete this item?")) {
                axios
                    .delete(`/clients/${item.id}`)
                    .then(response => {
                        this.$store.getters.clients.splice(index, 1);
                        //// console.log(response);
                    })
                    .catch(error => (this.errors = error.response.data.errors));
            }
        },
    },
    computed: {
        clients() {
            return this.$store.getters.clients
        },
        isLoading() {
            return this.$store.getters.loading;
        },
    },
    mounted() {
        eventBus.$emit("LoadingEvent");
        // this.$store.dispatch('getClients');
        this.getClients();
    },
    created() {
        eventBus.$on('boxEvent', data => {
            this.getClients();
        })
    },
}
</script>
