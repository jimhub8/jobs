<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Box</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-flex sm12>
                    <div>
                        <label for="">Statuses</label>
                        <el-input placeholder="Statuses name" v-model="form.status"></el-input>
                    </div>
                </v-flex>
                <v-flex sm12>
                    <div style="margin-top: 20px">
                        <label for="">Description</label>
                        <el-input type="textarea" placeholder="Please input" v-model="form.description" maxlength="300" show-word-limit>
                        </el-input>
                    </div>
                </v-flex>
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
        form: {
            status: '',
            description: '',
        },
    }),
    created() {
        eventBus.$on("openCreateBox", data => {
            this.dialog = true;
        });
    },
    methods: {
        save() {
            eventBus.$emit("LoadingEvent");
            this.loading = true;
            axios
                .post("status", this.$data.form)
                .then(response => {
                    this.loading = false;
                    // console.log(response);
                    // context.commit('getBoxes', response.data)
                    this.$store.dispatch('getStatus');
                    this.$store.dispatch('alertEvent', 'Statuses added')
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
    }
};
</script>
