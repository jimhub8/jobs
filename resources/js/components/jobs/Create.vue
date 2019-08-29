<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="700px">
        <v-card>
            <v-card-title>
                <span class="headline text-center" style="margin: auto;">Create Task</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-layout row wrap>
                    <v-flex sm5 style="margin: 10px 20px">
                        <div>
                            <label for="">Code</label>
                            <el-input placeholder="Code" v-model="form.code"></el-input>
                        </div>
                    </v-flex>
                    <v-flex sm5 style="margin: 10px 20px">
                        <div>
                            <label for="">Title</label>
                            <el-input placeholder="Title" v-model="form.title"></el-input>
                        </div>
                    </v-flex>
                    <v-flex sm5 style="margin: 10px 20px">
                        <div>
                            <label for="">Amount</label>
                            <el-input placeholder="amount" v-model="form.amount" type="number"></el-input>
                        </div>
                    </v-flex>
                    <v-flex sm12 style="margin: 10px 20px">
                        <div style="margin-top: 20px">
                            <label for="">Description</label>
                            <el-input type="textarea" placeholder="Please input" v-model="form.description" maxlength="300" show-word-limit>
                            </el-input>
                        </div>
                    </v-flex>
                </v-layout>
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
        });
    },
    computed: {
        tasks() {
            return this.$store.getters.tasks
        },
        cases() {
            return this.$store.getters.cases
        },
        users() {
            return this.$store.getters.users
        },
    },
    methods: {
        save() {
            eventBus.$emit("LoadingEvent");
            this.loading = true;
            axios
                .post("jobs_type", this.$data.form)
                .then(response => {
                    this.loading = false;
                    // console.log(response);
                    // context.commit('getBoxes', response.data)
                    this.$store.dispatch('getJobs');
                    this.$store.dispatch('alertEvent', 'Job added')
                    this.close();
                })
                .catch(error => {
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

<style scoped>
.el-select,
.el-date-editor.el-input,
.el-date-editor.el-input__inner {
    width: 100% !important;
}
</style>
