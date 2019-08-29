<template>
<div>
    <v-card>
        <VCardTitle primary-title>
            Inventory Pickup Notification
        </VCardTitle>
        <VDivider />
        <div v-for="notification in notifications" :key="notification.id">
            <router-link class="v-list__tile v-list__tile--link" v-if="notification.type == 'InventoryPickupNotification'">
                <div class="v-list__tile__action">
                    <i aria-hidden="true" class="icon material-icons">notifications</i>
                </div>
                <div class="v-list__tile__content">
                    <div class="v-list__tile__title">{{ notification.data.warehouseReceive['sku_no'] }}</div>
                </div>
            </router-link>
        </div>
    </v-card>
    <v-card>
        <VCardTitle primary-title>
            Low Stock Notification
        </VCardTitle>
        <VDivider />
        <div v-for="notification in notifications" :key="notification.id">
            <router-link class="v-list__tile v-list__tile--link" v-if="notification.type == 'LowStockNotification'">
                <div class="v-list__tile__action">
                    <i aria-hidden="true" class="icon material-icons">notifications</i>
                </div>
                <div class="v-list__tile__content">
                    <div class="v-list__tile__title">{{ notification.data.product['product_name'] }}</div>
                </div>
            </router-link>
        </div>
    </v-card>
</div>
</template>

<script>
export default {
    data() {
        return {

        }
    },
    methods: {
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
