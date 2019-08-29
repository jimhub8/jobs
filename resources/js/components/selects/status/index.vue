<template>
<div>
    <v-content>
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>
                <div class="container">
                    <v-card>
                        <h3 class="text-center">Statuses</h3>
                        <v-divider></v-divider>
                        <v-card-title>
                            <v-tooltip right>
                                <v-btn icon v-slot:activator="{ on }" class="mx-0" @click="getStatus">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                                <span>Refresh</span>
                            </v-tooltip>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="openCreate">Add Statuses</v-btn>
                            <!-- <v-btn text color="primary" @click="openEdit(selected)">Edit</v-btn> -->
                        </v-card-title>
                        <vue-good-table class="table-hover" :columns="columns" :rows="statuses" :search-options="{ enabled: true }" :pagination-options="{enabled: true,mode: 'pages'}" :sort-options="{enabled: true, initialSortBy: {field: 'status', type: 'asc'}}" v-loading="isLoading">
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
                                        <span>Edit</span>
                                    </v-tooltip>
                                    <v-tooltip bottom>
                                        <v-btn icon class="mx-0" @click="deleteItem(props.row)" v-slot:activator="{ on }">
                                            <v-icon small color="pink darken-2">delete</v-icon>
                                        </v-btn>
                                        <span>Delete</span>
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
</div>
</template>

<script>
import Create from './Create';
import Edit from './Edit';
export default {
    components: {
        Create,
        Edit,
    },
    data() {
        return {
            loading: false,
            isEmpty: false,
            loader: false,
            search: '',
            selected: [],

            columns: [
                {
                    label: 'Status',
                    field: 'status',
                },{
                    label: 'Description',
                    field: 'description',
                },
                {
                    label: 'Created On',
                    field: 'created_at',
                    type: 'date',
                    dateInputFormat: 'YYYY-MM-DD',
                    dateOutputFormat: 'MMM Do YYYY',
                },
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
        getStatus() {
            this.$store.dispatch('getStatus');
        },
        deleteItem(item) {
            console.log(item)
            const index = this.$store.getters.statuses.indexOf(item);
            if (confirm("Are you sure you want to delete this item?")) {
                axios
                    .delete(`/status/${item.id}`)
                    .then(response => {
                        this.$store.getters.statuses.splice(index, 1);
                        //// console.log(response);
                    })
                    .catch(error => (this.errors = error.response.data.errors));
            }
        },
    },
    computed: {
        statuses() {
            return this.$store.getters.status
        },
        isLoading() {
            return this.$store.getters.loading;
        },
    },
    mounted() {
        eventBus.$emit("LoadingEvent");
        // this.$store.dispatch('getStatus');
        this.getStatus();
    },
    created() {
        eventBus.$on('boxEvent', data => {
            this.getStatus();
        })
    },
}
</script>
