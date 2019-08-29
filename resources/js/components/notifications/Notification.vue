<template>
<v-card>
    <v-toolbar color="primary" dark>
        <!-- <v-toolbar-side-icon></v-toolbar-side-icon> -->

        <v-tooltip bottom>
            <v-btn icon v-slot:activator="{ on }" class="mx-0" @click="getnotifications">
                <v-icon color="white darken-2" small>refresh</v-icon>
            </v-btn>
            <span>Refresh</span>
        </v-tooltip>
        <v-toolbar-title>Notifications</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-tooltip bottom>
            <v-btn icon class="mx-0" v-slot:activator="{ on }" @click="markAll">
                <v-icon>check_circle</v-icon>
            </v-btn>
            <span>Mark all as read</span>
        </v-tooltip>
    </v-toolbar>

    <v-list two-line style="background: #f0f0f0;">
        <v-card>
            <VCardTitle style="background: rgb(185, 177, 177);">
                <div style="color: #fff;"> Inventory Pickup Notification</div>
            </VCardTitle>
            <template v-for="(notification, index) in notifications">
                <v-list-tile :key="notification.id" avatar ripple v-if="notification.type == 'InventoryPickupNotification'">
                    <v-list-tile-content>
                        <v-list-tile-title>{{ notification.data.warehouseReceive['sku_no'] }}</v-list-tile-title>
                        <v-list-tile-sub-title class="text--primary">{{ notification.data.warehouseReceive['sku_no'] }}</v-list-tile-sub-title>
                        <v-list-tile-sub-title>{{ notification.data.warehouseReceive['created_at'] }}</v-list-tile-sub-title>
                    </v-list-tile-content>

                    <v-list-tile-action>
                        <v-list-tile-action-text>{{ notification.action }}</v-list-tile-action-text>
                        <v-tooltip bottom>
                            <v-btn icon class="mx-0" v-slot:activator="{ on }" @click="markRead(notification)">
                                <v-icon>check_circle</v-icon>
                            </v-btn>
                            <span>Mark as read</span>
                        </v-tooltip>
                    </v-list-tile-action>

                </v-list-tile>
                <v-divider v-if="index + 1 < notifications.length" :key="index"></v-divider>
            </template>
        </v-card>
        <v-divider></v-divider>
        <v-card>
            <VCardTitle  style="background: rgb(185, 177, 177);">
                <div style="color: #fff;">Low Stock Notification</div>
            </VCardTitle>
            <template v-for="(notification, index) in notifications">
                <v-list-tile :key="notification.id" v-if="notification.type == 'LowStockNotification'" avatar ripple @click="openEdit(notification.data.product)">
                    <v-list-tile-content>
                        <v-list-tile-title>{{ notification.data.product['product_name'] }}</v-list-tile-title>
                        <v-list-tile-sub-title class="text--primary">{{ notification.data.product['product_name'] }}</v-list-tile-sub-title>
                        <v-list-tile-sub-title>{{ notification.data.product['created_at'] }}</v-list-tile-sub-title>
                    </v-list-tile-content>

                    <v-list-tile-action>
                        <v-list-tile-action-text>{{ notification.action }}</v-list-tile-action-text>
                        <v-tooltip bottom>
                            <v-btn icon class="mx-0" v-slot:activator="{ on }" @click="markRead(notification)">
                                <v-icon>check_circle</v-icon>
                            </v-btn>
                            <span>Mark as read</span>
                        </v-tooltip>
                    </v-list-tile-action>

                </v-list-tile>
                <v-divider v-if="index + 1 < notifications.length" :key="index"></v-divider>
            </template>
        </v-card>
    </v-list>
</v-card>
</template>

<script>
export default {
    data() {
        return {
            selected: [2],
        }
    },
    methods: {
        openEdit(item) {
            console.log(item);

            this.$router.push({
                name: "editProducts",
                params: {
                    id: item.id
                }
            });
        },
        markAll(item) {
            const index = this.notifications.indexOf(item)
            axios
                .delete(`/notifications/${item.id}`)
                .then(response => {
                    this.notifications.splice(index, 1)
                    this.$store.dispatch('alertEvent', 'Marked')
                })
                .catch(error => {
                    this.loading = false;
                });
        },
        markAll(item) {
            const index = this.notifications.indexOf(item)
            axios
                .delete(`/notifications/${item.id}`)
                .then(response => {
                    this.notifications.splice(index, 1)
                    // this.$store.dispatch('alertEvent', 'Marked')
                    this.getnotifications()
                })
                .catch(error => {
                    this.loading = false;
                });
        },

        getnotifications() {
            this.$store.dispatch('getnotifications')
        }
    },
    computed: {
        notifications() {
            return this.$store.getters.notifications
        }
    },
}
</script>

<style>

</style>
