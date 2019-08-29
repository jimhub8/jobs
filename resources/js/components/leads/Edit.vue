<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Edit Leads</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <VCard>
                            <v-flex sm12>
                                <v-card-text>
                                    <div>
                                        <label for="">Client Name</label>
                                        <el-input placeholder="Full name" v-model="form.client_name"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Email Address</label>
                                        <el-input type="email" placeholder="doe@gmail.com" v-model="form.client_email"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Client Phone Number</label>
                                        <el-input placeholder="0700..." v-model="form.client_phone"></el-input>
                                    </div>
                                    <div>
                                        <label for="">Status</label>
                                        <el-select v-model="form.status" clearable placeholder="Status" style="width: 100%;">
                                            <el-option v-for="item in options" :key="item.value" :label="item.value" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div style="margin-top: 20px">
                                        <label for="">Details</label>
                                        <el-input type="textarea" placeholder="Please input something" v-model="form.details" maxlength="300" show-word-limit>
                                        </el-input>
                                    </div>
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
        ]
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
                .patch(`/leads/${this.form.id}`, this.$data.form)
                .then(response => {
                    this.loading = false;
                    // console.log(response);
                    // context.commit('getBoxes', response.data)
                    this.$store.dispatch('alertEvent', 'Lead Updated')
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
