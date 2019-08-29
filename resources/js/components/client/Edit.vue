<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Box</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <VCard>
                            <v-flex sm12>
                                <v-card-text>
                                    <!-- <div>
                                        <label for="">Firm</label>
                                        <el-select v-model="form.firm_id" clearable placeholder="Firm" style="width: 100%;">
                                            <el-option v-for="item in firms" :key="item.id" :label="item.name" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </div> -->
                                    <div>
                                        <label for="">Full Name</label>
                                        <el-input placeholder="Full name" v-model="form.name"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Email Address</label>
                                        <el-input placeholder="email" v-model="form.email"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Phone Number</label>
                                        <el-input placeholder="number" v-model="form.phone"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Address</label>
                                        <el-input placeholder="address" v-model="form.address"></el-input>
                                    </div>

                                    <div>
                                        <label for="">Address</label>
                                    </div>
                                    <VDivider />
                                    <v-layout row wrap>
                                        <v-flex sm5>
                                            <label for="">Next of kin</label>
                                            <el-input placeholder="nextof_kin" v-model="form.nextof_kin"></el-input>
                                        </v-flex>
                                        <v-flex sm5 style="margin-left: 87px">
                                            <label for="">Counsel</label>
                                            <el-input placeholder="counsel" v-model="form.counsel"></el-input>
                                        </v-flex>
                                    </v-layout>
                                    <label for="">Case Nature</label>
                                    <el-input placeholder="case nature" v-model="form.case_nature"></el-input>
                                </v-card-text>
                            </v-flex>
                        </VCard>
                    </v-layout>

                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" text @click="close">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="save" :loading="loading" :disabled="loading">Update</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        loading: false,
        form: {},
    }),

    created() {
        eventBus.$on("openEditBox", data => {
            this.dialog = true;
            this.form = data
            this.getFirms()
        });
    },
    computed: {
        firms() {
            return this.$store.getters.firms
        }
    },
    methods: {
        save() {
            eventBus.$emit("LoadingEvent");
            this.loading = true;
            axios
                .patch(`/clients/${this.form.id}`, this.$data.form)
                .then(response => {
                    this.loading = false;
                    // console.log(response);
                    // context.commit('getBoxes', response.data)
                    this.$store.dispatch('alertEvent', 'Client Updated')
                    eventBus.$emit("boxEvent", data);
                    this.close();
                })
                .catch(error => {
                    eventBus.$emit("stopLoadingEvent");
                    // console.log(error.response);
                    this.loading = false;
                });
        },
        close() {
            this.dialog = false;
        },
        getFirms() {
            // this.$store.dispatch('getFirms')
        }
    }
};
</script>
