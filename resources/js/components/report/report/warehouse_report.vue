<template>
<div>
    <!-- <v-text-field color="success" :loading="loading"></v-text-field> -->
    <v-card class="mx-auto" style="padding: 10px;text-align: center;">
        <VCardTitle primary-title>
            <h1 style="margin: auto;">Warehouse Report</h1>
        </VCardTitle>
        <VDivider />
        <v-card-text>
            <label for="">Warehouse</label>
            <el-select v-model="warehouse_report.warehouse" multiple filterable clearable placeholder="Select warehouse" style="width: 100%;">
                <el-option v-for="item in warehouses" :key="item.id" :label="item.name" :value="item.id">
                </el-option>
            </el-select>
            <label for="">Warehouse</label>
            <el-select v-model="warehouse_report.option" filterable clearable placeholder="Select" style="width: 100%;">
                <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                </el-option>
            </el-select>
            <div style="margin: 20px 0;"></div>
            <div class="block">
                <span class="demonstration" style="float: left">Start Date</span>
                <el-date-picker v-model="warehouse_report.start_date" type="date" placeholder="Pick a day" style="width: 100%;">
                </el-date-picker>
            </div>
            <div class="block">
                <span class="demonstration" style="float: left">End Date</span>
                <el-date-picker v-model="warehouse_report.end_date" type="date" placeholder="Pick a day" style="width: 100%;">
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
            form: {
                search: ''
            },
            warehouse_report: {
                start_date: '',
                end_date: '',
                option: '',
                warehouse: [],
            },
            options: [{
                value: 'Orders',
                label: 'Orders'
            }, {
                value: 'Products',
                label: 'Products'
            },],
            value: [],
            loading: false,
            report_data: [],
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
        this.$store.dispatch('getWarehouses')
    },
    methods: {

        getReport(query) {
            this.loading = true;
            this.form.search = query
            // this.$store.dispatch('getWarehouses');
            axios.post('warehouse_report', this.warehouse_report).then((response) => {
                this.loading = false
                this.report_data = response.data
            }).catch((error) => {
                this.loading = false;

            })
        },
    },
    computed: {
        warehouses() {
            return this.$store.getters.warehouse
        },
    },
}
</script>
