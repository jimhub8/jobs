<template>
<div>
    <v-toolbar tabs style="margin-bottom: 15px;background: #e64b23;z-index: 1;margin-top: -30px;">

        <template v-slot:extension>
            <v-tabs v-model="tabs" fixed-tabs color="transparent">
                <v-tabs-slider></v-tabs-slider>
                <v-tab href="#mobile-tabs-5-1" class="primary--text">
                    <v-icon color="white">dashboard</v-icon>
                </v-tab>

                <v-tab href="#mobile-tabs-5-2" class="primary--text">
                    <v-icon color="white">account_box</v-icon>
                </v-tab>
            </v-tabs>
        </template>
    </v-toolbar>
    <v-content>
        <div v-show="loader" style="text-align: center; width: 100%;">
            <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
        </div>
        <!-- <v-container fluid fill-height v-show="!loader"> -->
        <v-layout justify-center align-center>
            <v-tabs-items v-model="tabs" class="white elevation-1" style="width: 100%">

                <v-tab-item value="mobile-tabs-5-1">
                    <Dashboard :user='user'></Dashboard>
                </v-tab-item>

                <v-tab-item value="mobile-tabs-5-2">
                    <v-layout row wrap style="margin-top: 20px;padding:20px;">
                        <v-flex xs12 sm4>
                            <v-card>
                                <img
                                :src="avatar"
                                style="width: 100px; height: 100px; border-radius: 50%; text-align:center; margin-top 70px;margin-left-100px"
                                >
                                <v-divider></v-divider>
                                <h5 class="text-center">{{ user.name }}</h5>
                                <h6 class="text-center" v-for="role in user.roles" :key="role.id">{{ role.name }}</h6>
                                <v-btn color="red" darken-1 raised @click="onPickFile" style="color: #fff;">Upload</v-btn>
                                <input
                                type="file"
                                @change="Getimage"
                                accept="image/*"
                                style="display: none"
                                ref="fileInput"
                                >
                                <img v-show="imagePlaced" :src="avatar" style="width: 200px; height: 200px;">
                                <v-btn @click="upload" text v-show="imagePlaced" :loading="loading" :disabled="loading">Upload</v-btn>
                                <v-btn @click="cancle" text v-show="imagePlaced">Cancel</v-btn>
                            </v-card>
                        </v-flex>

                        <!-- User Form -->
                        <v-flex xs12 sm7 offset-sm1>
                            <v-card text>
                                <v-snackbar v-model="snackbar" absolute top right color="black">
                                    <span>Details updated</span>
                                    <v-icon dark>check_circle</v-icon>
                                </v-snackbar>
                                <v-form ref="form" @submit.prevent="submit">
                                    <v-container grid-list-xl fluid>
                                        <v-layout wrap>
                                            <v-flex xs12 sm6>
                                                <v-text-field v-model="LogedUser.name" :rules="rules.name" color="purple darken-2" label="Full name" required></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6>
                                                <v-text-field v-model="LogedUser.email" :rules="emailRules" color="blue darken-2" label="Email" required></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6>
                                                <v-text-field v-model="LogedUser.address" :rules="rules.name" color="blue darken-2" label="Address" required></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6>
                                                <v-text-field v-model="LogedUser.city" :rules="rules.name" color="blue darken-2" label="City" required></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6>
                                                <v-text-field v-model="LogedUser.country" :rules="rules.name" color="blue darken-2" label="Country" required></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 sm6>
                                                <v-text-field v-model="LogedUser.phone" :rules="rules.name" color="blue darken-2" label="Phone" required></v-text-field>
                                            </v-flex>
                                            <!-- <v-flex xs12 sm6>
                                            <v-text-field v-model="LogedUser.branch" :rules="rules.name" color="blue darken-2" label="Branch" required></v-text-field>
                          </v-flex>-->
                                        </v-layout>
                                    </v-container>
                                    <v-card-actions>
                                        <v-btn text @click="resetForm">reset</v-btn>
                                        <v-spacer></v-spacer>
                                        <v-btn :disabled="loading" :loading="loading" text color="primary" @click="update">Submit</v-btn>
                                    </v-card-actions>
                                </v-form>
                                <v-divider></v-divider>
                                <v-card-text>
                                    <v-form ref="form" @submit.prevent>
                                        <v-flex xs12 sm12>
                                            <v-text-field :append-icon="e1 ? 'visibility_off' : 'visibility'" :type="e1 ? 'password' : 'text'" v-model="form.password" name="input-10-2" label="Enter your password" hint="At least 6 characters" min="8" value class="input-group--focused"></v-text-field>
                                            <small
                                            class="has-text-danger"
                                            v-if="errors.password"
                                        >{{ errors.password[0] }}</small>
                                        </v-flex>
                                    </v-form>
                                </v-card-text>
                                <v-card-actions>
                                    <v-btn :disabled="ploading" :loading="ploading" text color="primary" @click="passwordChange">Change Password</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-flex>
                        <!-- User Form -->
                    </v-layout>
                </v-tab-item>

            </v-tabs-items>
        </v-layout>
        <!-- </v-container> -->
    </v-content>
</div>
</template>

<script>
import Dashboard from "./Dashboard";
export default {
    props: ["user"],
    components: {
        Dashboard
    },
    data() {
        const defaultForm = Object.freeze({
            name: "",
            password: "",
            phone: null,
            branch: "",
            address: "",
            city: "",
            country: ""
        });
        return {
            // tab_color: '#e64b23',
            imagePlaced: false,
            defaultForm,
            loading: false,
            errors: [],
            avatar: "",
            tabs: null,
            LogedUser: {},
            ploading: false,
            e1: true,
            snackbar: false,
            loader: false,
            form: Object.assign({}, defaultForm),
            emailRules: [
                v => {
                    return !!v || "E-mail is required";
                },
                v =>
                /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
                "E-mail must be valid"
            ],
            rules: {
                name: [val => (val || "").length > 0 || "This field is required"]
            }
        };
    },
    methods: {
        // Image Upload
        onPickFile() {
            this.$refs.fileInput.click();
        },
        onFilePicked(event) {
            this.imagePlaced = true;
            const files = event.target.files;
            let filename = files[0].name;
            if (filename.lastIndexOf(".") <= 0) {
                return alert("please upload a valid image");
            }
            const fileReader = new FileReader();
            fileReader.addEventListener("load", () => {
                this.avatar = fileReader.result;
            });
            fileReader.readAsDataURL(files[0]);
            this.image = files[0];
        },
        Getimage(e) {
            let image = e.target.files[0];
            // this.read(image);
            let reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = e => {
                this.avatar = e.target.result;
            };
            this.imagePlaced = true;
            let form = new FormData();
            form.append("image", image);
            this.file = form;
            console.log(e.target.files);
        },

        upload() {
            this.loading = true;
            axios
                .post(`/profile/${this.LogedUser.id}`, this.file)
                .then(response => {
                    this.loading = false;
                    // console.log(response);
                    this.imagePlaced = false;
                    this.color = "black";
                    this.text = "Profile image updated";
                    this.snackbar = true;
                    // this.close()
                })
                .catch(error => {
                    this.loading = false;
                    if (error.response.status === 500) {
                        eventBus.$emit("errorEvent", error.response.statusText);
                        return;
                    }
                    this.errors = error.response.data.errors;
                    this.errors = error.response.data.errors;
                });
        },
        passwordChange() {
            this.ploading = true;
            axios
                .post("/password", this.form)
                .then(response => {
                    this.ploading = false;
                    this.color = "black";
                    this.text = "Password updated";
                    this.snackbar = true;
                    // this.close()
                })
                .catch(error => {
                    this.ploading = false;
                    this.errors = error.response.data.errors;
                });
        },
        cancle() {
            this.avatar = this.LogedUser.profile;
            this.imagePlaced = false;
        },
        resetForm() {
            this.LogedUser = Object.assign({}, this.defaultForm);
            this.$refs.LogedUser.reset();
        },
        update() {
            this.loading = true;
            axios
                .patch(`/AuthUserUp/${this.LogedUser.id}`, this.$data.LogedUser)
                .then(response => {
                    // console.log(response);
                    this.loading = false;
                    this.snackbar = true;
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    this.loading = false;
                });
        }
    },
    mounted() {
        this.loader = true;
        axios
            .get("/getLogedinUsers")
            .then(response => {
                this.LogedUser = response.data;
                this.avatar = response.data.profile;
                this.loader = false;
            })
            .catch(error => {
                this.errors = error.response.data.errors;
                this.loader = false;
            });
    },

    computed: {
        formIsValid() {
            return (
                this.LogedUser.name &&
                this.LogedUser.email &&
                this.LogedUser.phone &&
                this.LogedUser.branch &&
                this.LogedUser.address &&
                this.LogedUser.city &&
                this.LogedUser.country
            );
        }
    }
};
</script>
