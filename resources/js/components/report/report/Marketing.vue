<template>
<div>
    <!-- <v-text-field color="success" :loading="loading"></v-text-field> -->
    <v-card class="mx-auto" style="padding: 10px;text-align: center;">
        <VCardTitle primary-title>
            <h1 style="margin: auto;">Product Report</h1>
        </VCardTitle>
        <VDivider />
        <v-card-text>
            <div class="block">
                <span class="demonstration" style="float: left">Staff</span>
                <el-select v-model="form.staff" multiple filterable remote reserve-keyword placeholder="type at least 3 letters" :remote-method="filterUsers" :loading="loading" style="width: 100%;">
                    <el-option v-for="item in users" :key="item.id" :label="item.name" :value="item.id">
                    </el-option>
                </el-select>
            </div>
            <div class="block">
                <span class="demonstration" style="float: left">Status</span>
                <el-select v-model="form.status" placeholder="Select" style="width: 100%;">
                    <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <div class="block">
                <span class="demonstration" style="float: left">Start Date</span>
                <el-date-picker v-model="form.start_date" type="date" placeholder="Pick a day" style="width: 100%;">
                </el-date-picker>
            </div>
            <div class="block">
                <span class="demonstration" style="float: left">End Date</span>
                <el-date-picker v-model="form.end_date" type="date" placeholder="Pick a day" style="width: 100%;">
                </el-date-picker>
            </div>
        </v-card-text>

        <v-card-actions>
            <v-btn text color="info" flat @click="getReport" :loading="loading" :disabled="loading">
                Get Report
            </v-btn>
            <VSpacer />
            <!-- <v-btn text color="primary" flat>
            Download excel
        </v-btn> -->
            <download-excel :data="report_data" :fields="json_fields">
                <!-- Download file
                <img src="storage/ex.png"> -->
                <v-btn text color="primary" flat>
                    Download excel
                </v-btn>
            </download-excel>
            <!-- <v-btn icon>
            <v-icon>mdi-heart</v-icon>
        </v-btn>
        <v-btn icon>
            <v-icon>mdi-share-variant</v-icon>
        </v-btn> -->
        </v-card-actions>
    </v-card>
</div>
</template>

<script>
export default {
    data() {
        return {
            form: {},
            inventory_details: {
                start_date: '',
                end_date: '',
            },
            options: [{
                    lable: 'open',
                    value: 'open',
                },
                {
                    lable: 'Closed',
                    value: 'Closed',
                },
                {
                    lable: 'Cancelled',
                    value: 'Cancelled',
                }
            ],
            value: [],
            loading: false,
            users: {},
            report_data: [],
            search_data: '',
            json_fields: {
                'Product Name': 'product_name',
                'Product Sku': 'sku_no',
                'Product Barcode': 'barcode',
                'Reorder Point': 'reorder_point',
                'Description': 'description',
                'Product Value/price': 'price',
                'Client Name': 'client.name',
                'Client Email': 'client.email',
                'Client Phone': 'client.phone',
                'Client Address': 'client.address',
                'Order status': 'active',
                'Created On': 'created_at',
            },
        }
    },
    mounted() {
        // this.$store.dispatch('getUsers')
    },
    methods: {
        filterUsers(query) {
            if (query.length > 2) {
                this.loading = true;
                axios.get(`filter_users/${query}`).then((response) => {
                    this.loading = false
                    this.users = response.data
                    this.users = response.data.filter(item => {
                        return item.name.toLowerCase()
                            .indexOf(query.toLowerCase()) > -1;
                    });
                }).catch((error) => {
                    this.loading = false
                })
            }
        },
        getReport(query) {
            this.loading = true;
            this.form.search = query
            // this.$store.dispatch('getUsers');
            axios.post('marketing', this.form).then((response) => {
                this.loading = false
                this.report_data = response.data
            }).catch((error) => {
                this.loading = false;

            })
        },

    },
    computed: {
        // users() {
        //     return this.$store.getters.users
        // },
    },
}
</script>
