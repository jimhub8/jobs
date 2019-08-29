<template>
<v-app dark>

    <!-- <v-navigation-drawer right temporary v-model="drawerRight" fixed>
        <v-list dense style="background: #f0f0f0;">
            <template>
                <Notifications></Notifications>
            </template>
        </v-list>
    </v-navigation-drawer> -->
    <v-navigation-drawer v-model="drawer" fixed app>
        <v-list dense>
            <v-img :aspect-ratio="16/9" src="http://web.speedballcourier.com/storage/ps/landS.jpg">
                <v-layout pa-2 column fill-height class="lightbox white--text">
                    <v-spacer></v-spacer>
                    <v-flex shrink>
                        <div class="subheading">{{ user.name }}</div>
                        <div class="body-1">{{ user.email }}</div>
                    </v-flex>
                </v-layout>
            </v-img>
            <template>
                <v-list rounded>
                    <router-link to="/" class="v-list-item v-list-item--link theme--light">
                        <div class="v-list-item__icon">
                            <i aria-hidden="true" class="icon material-icons">dashboard</i>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">Dashboard</div>
                        </div>
                    </router-link>
                    <router-link to="/clients" class="v-list-item v-list-item--link theme--light">
                        <div class="v-list-item__icon">
                            <i aria-hidden="true" class="icon material-icons">people_outline</i>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">Clients</div>
                        </div>
                    </router-link>
                    <router-link to="/leads" class="v-list-item v-list-item--link theme--light">
                        <div class="v-list-item__icon">
                            <i aria-hidden="true" class="icon material-icons">business</i>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">Leads</div>
                        </div>
                    </router-link>
                    <router-link to="/reports" class="v-list-item v-list-item--link theme--light">
                        <div class="v-list-item__icon">
                            <i aria-hidden="true" class="icon material-icons">book</i>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">Reports</div>
                        </div>
                    </router-link>
                    <router-link to="/jobs" class="v-list-item v-list-item--link theme--light">
                        <div class="v-list-item__icon">
                            <i aria-hidden="true" class="icon material-icons">book</i>
                        </div>
                        <div class="v-list-item__content">
                            <div class="v-list-item__title">Jobs</div>
                        </div>
                    </router-link>
                    <v-list-group prepend-icon="gavel">
                        <template v-slot:activator>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        User&Roles
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                        <div style="background: #f0f0f0 !important;border-radius: 10px !important;">
                            <router-link to="/users" class="v-list-item v-list-item--link theme--light" style="text-decoration: none">
                                <v-list-item-action>
                                    <v-icon>people_outline</v-icon>
                                </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        User
                                    </v-list-item-title>
                                </v-list-item-content>
                            </router-link>
                            <router-link to="/roles" class="v-list-item v-list-item--link theme--light" style="text-decoration: none">
                                <v-list-item-action>
                                    <v-icon>gavel</v-icon>
                                </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        Roles
                                    </v-list-item-title>
                                </v-list-item-content>
                            </router-link>
                        </div>
                    </v-list-group>
                </v-list>
            </template>
        </v-list>
    </v-navigation-drawer>
    <!-- <v-toolbar :color="color" dark fixed app> -->
    <v-app-bar app color="blue darken-3" dark>
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        <img src="/storage/logo.jpeg" alt style="width: 130px; height: 60px;border-radius: 20px;">
        <div class="flex-grow-1"></div>
        <v-app-bar-nav-icon @click.stop="drawerRight = !drawerRight"></v-app-bar-nav-icon>

        <VSpacer />
        <Logout :user="user"></Logout>
        <VDivider vertical style="margin-top: 0px;" />
    </v-app-bar>

    <v-snackbar :timeout="timeout" bottom :color="Snackcolor" right v-model="snackbar">
        {{ message }}
        <v-icon dark right>{{ icon }}</v-icon>
    </v-snackbar>
    <v-footer style="background: #e2e0e0 !important;" app>
        <span style="color: #000; margin: auto;">Mft fulfillment center &copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
</v-app>
</template>

<script>
import Notifications from "../notifications/Notification";
// // import AddShipment from "../shipments/AddShipment";
// import { vueTopprogress } from "vue-top-progress";
import Logout from "./Logout";
// import chattyNoty from '../notification/chattyNoty'
export default {
    components: {
        Notifications,
        Logout
    },
    props: ["user"],
    data() {
        return {
            icon: "",
            Snackcolor: '',
            color: "rgb(25, 117, 210)",
            loading: false,
            dialog: false,
            drawer: true,
            drawerRight: false,
            right: null,
            mode: "",
            snackbar: false,
            timeout: 5000,
            message: "Success",
            item: 1,
            items: [{
                    text: 'Real-Time',
                    icon: 'mdi-clock'
                },
                {
                    text: 'Audience',
                    icon: 'mdi-account'
                },
                {
                    text: 'Conversions',
                    icon: 'mdi-flag'
                },
            ],
        };
    },
    methods: {
        close() {
            this.dialog = false;
        },

        successAlert(data) {
            this.message = data;
            this.Snackcolor = "black";
            this.snackbar = true;
            this.icon = 'check_circle'
        },

        errorAlert(data) {
            this.message = data;
            this.Snackcolor = "red";
            this.snackbar = true;
            this.icon = 'block'
        },
        openFullScreen() {
            this.loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
        },
        closeFullScreen() {
            this.loading.close();
        },
        // getnotifications() {
        //     this.$store.dispatch('getnotifications')
        // }
    },
    created() {
        eventBus.$on("progressEvent", data => {
            this.$refs.topProgress.start();
        });
        eventBus.$on("StoprogEvent", data => {
            this.$refs.topProgress.done();
        });
        eventBus.$on("alertRequest", data => {
            this.successAlert(data)
        });
        eventBus.$on("errorEvent", data => {
            this.errorAlert(data)
        });
        eventBus.$on("LoadingEvent", data => {
            // this.openFullScreen(data)
        });
        eventBus.$on("stopLoadingEvent", data => {
            // this.closeFullScreen(data)
        });

        eventBus.$on("notificationCountEvent", data => {
            this.notification = data
        });
    },
    computed: {
        // notifications() {
        //     return this.$store.getters.notifications
        // }
    },
    mounted() {
        // this.getnotifications();
    },

};
</script>

<style scoped>
.v-expansion-panel__container:hover {
    border-radius: 10px !important;
    width: 90% !important;
    margin-left: 15px !important;
    background: #e3edfe !important;
    color: #1a73e8 !important;
}

/* .theme--light {
    background-color: #212120 !important;
    color: #fff !important;
} */

.v-toolbar[data-booted=true] {
    transition: .2s cubic-bezier(.4, 0, .2, 1);
    z-index: 100 !important;
}

.theme--light[data-v-67cb1297] {
    z-index: 101 !important;
}


.theme--light.v-navigation-drawer {
    width: 300px !important;
    margin-top: -20px !important;
    /* background-color: #212120 !important;
    color: #fff !important; */
}

.v-list-group--active .v-list-group__items {
    background: red !important;
    border-radius: 10px !important;
}
</style>
