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
                        <VCard style="width: 100%">
                            <v-flex sm12>
                                <v-card-text>
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
                                        <label for="">Details</label>
                                    </div>
                                    <VDivider />
                                    <v-layout row wrap>
                                        <v-flex sm5>
                                            <label for="">Contact person</label>
                                            <el-input placeholder="contact_person" v-model="form.contact_person"></el-input>
                                        </v-flex>
                                        <v-flex sm5 style="margin-left: 87px">
                                            <label for="">Contact person phone no.</label>
                                            <el-input placeholder="contact_person_phone" v-model="form.contact_person_phone"></el-input>
                                        </v-flex>
                                    </v-layout>
                                </v-card-text>
                            </v-flex>
                        </VCard>
                    </v-layout>

                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" text @click="close">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="save" :loading="loading" :disabled="loading">Save</v-btn>
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
        eventBus.$on("openCreateBox", data => {
            this.dialog = true;
            // this.getFirms()
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
                .post("clients", this.$data.form)
                .then(response => {
                    this.loading = false;
                    // console.log(response);
                    // context.commit('getBoxes', response.data)
                    this.$store.dispatch('getClients');
                    this.$store.dispatch('alertEvent', 'Client added')
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
            this.$store.dispatch('getFirms')
        }
    }
};
</script>
