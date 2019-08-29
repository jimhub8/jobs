<template>
<div>
    <v-content>
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>
                <div class="container">
                    <v-card>
                        <h3 class="text-center">jobs</h3>
                        <v-divider></v-divider>
                        <v-card-title>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" @click="getJobs" color="primary">
                                        <v-icon color="grey lighten-1">refresh</v-icon>
                                    </v-btn>
                                </template>
                                <span>Refresh</span>
                            </v-tooltip>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="openCreate">Add Task</v-btn>
                            <!-- <v-btn text color="primary" @click="openEdit(selected)">Edit</v-btn> -->
                        </v-card-title>
                        <vue-good-table class="table-hover" :columns="columns" :rows="jobs.data" :search-options="{ enabled: true }" :pagination-options="{enabled: true,mode: 'pages'}" :sort-options="{enabled: true, initialSortBy: {field: 'name', type: 'asc'}}" v-loading="isLoading">
                            <template slot="table-row" slot-scope="props">

                                <span v-if="props.column.field == 'actions'">
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
                    label: 'Code#',
                    field: 'code',
                },
                {
                    label: 'Job Title',
                    field: 'title',
                },
                {
                    label: 'Description',
                    field: 'description',
                },
                // {
                //     label: 'Created On',
                //     field: 'created_at',
                //     type: 'date',
                //     // dateInputFormat: 'YYYY-MM-DD',
                //     // dateOutputFormat: 'MMM Do YYYY',
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
            eventBus.$emit('openEditTask', data)
        },

        openShow(data) {
            eventBus.$emit('openShowBox', data)
        },
        getJobs() {
            eventBus.$emit("LoadingEvent");
            this.$store.dispatch('getJobs');
        },
        deleteItem(item) {
            console.log(item)
            const index = this.$store.getters.job.indexOf(item);
            if (contask("Are you sure you want to delete this item?")) {
                axios
                    .delete(`/jobs_type/${item.id}`)
                    .then(response => {
                        this.getJobs();
                        //// console.log(response);
                    })
                    .catch(error => (this.errors = error.response.data.errors));
            }
        },
    },
    computed: {
        jobs() {
            return this.$store.getters.jobs
        },
        isLoading() {
            return this.$store.getters.loading;
        },
    },
    mounted() {
        eventBus.$emit("LoadingEvent");
        // this.$store.dispatch('getJobs');
        this.getJobs();
    },
    created() {
        eventBus.$on('TaskRefreshEvent', data => {
            this.getJobs();
        })
    },
}
</script>
