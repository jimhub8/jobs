<template>
<v-content style="margin-top: 50px !important;">
    <v-container fluid fill-height>
        <v-layout justify-center align-center>
            <v-flex sm12>
                <el-row :gutter="12" style="width: 100%">
                    <el-col :span="4">
                        <el-card shadow="hover">
                            <div class="text-center">
                                <p style="font-size: 36px;color: #1093de;">0</p>
                                <small>Today</small>
                                <!-- <v-icon dark right style="padding: 0;font-size: 39px !important;">check_circle</v-icon><span>Hover</span> -->
                                <h5>Today Cases</h5>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="4">
                        <el-card shadow="hover">
                            <div class="text-center">
                                <p style="font-size: 36px;color: #db3f26;">2</p>
                                <small>Cases</small>
                                <!-- <v-icon dark right style="padding: 0;font-size: 39px !important;">check_circle</v-icon><span>Hover</span> -->
                                <h5>All Cases</h5>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="4" v-for="role in user.roles" :key="role.id" v-if="role.name === 'Super admin'">
                        <el-card shadow="hover">
                            <div class="text-center">
                                <p style="font-size: 36px;color: #388a10;">5</p>
                                <small>firms</small>
                                <!-- <v-icon dark right style="padding: 0;font-size: 39px !important;">check_circle</v-icon><span>Hover</span> -->
                                <h5>Firms</h5>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="4">
                        <el-card shadow="hover">
                            <div class="text-center">
                                <p style="font-size: 36px;color: #f4a204;">4</p>
                                <small>Closed</small>
                                <!-- <v-icon dark right style="padding: 0;font-size: 39px !important;">check_circle</v-icon><span>Hover</span> -->
                                <h5>Closed</h5>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="4">
                        <el-card shadow="hover">
                            <div class="text-center">
                                <p style="font-size: 36px;color: #f4a204;">4</p>
                                <small>Open</small>
                                <!-- <v-icon dark right style="padding: 0;font-size: 39px !important;">check_circle</v-icon><span>Hover</span> -->
                                <h5>Open</h5>
                            </div>
                        </el-card>
                    </el-col>
                </el-row>
            </v-flex>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
export default {
    props: ["user"],
    data() {
        return {
            chartData: [["Jan", 4], ["Feb", 2], ["Mar", 10], ["Apr", 5], ["May", 3], ["June", 12], ["July", 7], ["Aug", 3], ["Sept", 13], ["Oct", 23], ["Nov", 3], ["Dec", 22]]
        }
    },
    methods: {
        getLowstock() {
            this.$store.dispatch('getLowstock')
        }
    },
    computed: {
        low_stoke() {
            return this.$store.getters.low_stoke
        },
        tobe_received() {
            return this.$store.getters.tobe_received
        },
        onhand() {
            return this.$store.getters.onhand
        },
        product_count() {
            return this.$store.getters.product_count
        },
        chartsummary() {
            return this.$store.getters.chartsummary
        },
        active_chart() {
            return this.$store.getters.active_chart
        },
    },
    mounted() {
        // this.$store.dispatch('product_count')
        // this.$store.dispatch('tobe_received')
        // this.$store.dispatch('getOnhand')
        // this.$store.dispatch('getLowstock')

        // // Charts
        // this.$store.dispatch('getChartSummary')
        // this.$store.dispatch('getActiveProducts')
    },
}
</script>

<style scoped>
.justify-center {
    margin-top: -100px !important;
}

.card-stats {
    margin-top: -10px;
    padding: 20px 0;
}

/* .statistics {
    background: #f0f0f0 !important;
} */

.progress-Ship {
    margin-top: 100px !important;
}

.v-icon {
    font-size: 64px !important;
}

.v-icon {
    box-shadow: 0 9px 30px -6px rgba(255, 54, 54, .5);
    padding: 5px;
    border-radius: 50%;
}

.info-title {
    margin-top: 20px;
}
</style>
