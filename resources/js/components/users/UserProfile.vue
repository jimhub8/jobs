<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card v-if="dialog">
            <v-card-title>
                <span class="headline">{{ user.name }} Profile</span>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <!-- <avatar :username="user.name" style="font-size: 40px;margin: auto;padding: 50px;"></avatar> -->
                <!-- <img :src="user.profile" :alt="user.name" style="width: 150px; height: 150px; border-radius: 50%; text-align:center; margin-top 70px;margin-left-100px;margin-left: 45%;"> -->
                <ul class="list-group">
                    <li class="list-group-item active"><b>Client Details</b></li>
                    <li class="list-group-item"><label for="">Name:</label><span style="float: right;">{{ user.name }}</span></li>
                    <li class="list-group-item"><label for="">Phone:</label><span style="float: right;">{{ user.phone }}</span></li>
                    <li class="list-group-item"><label for="">Email:</label><span style="float: right;">{{ user.email }}</span></li>
                    <li class="list-group-item"><label for="">City:</label><span style="float: right;">{{ user.city }}</span></li>
                    <li class="list-group-item"><label for="">Address:</label><span style="float: right;">{{ user.address }}</span></li>
                    <li class="list-group-item"><label for="">Role:</label><span style="float: right;" v-for="role in user.roles" :key="role.id">{{ role.name }}</span></li>
                </ul>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" text @click.native="close">Close</v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
// import Avatar from 'vue-avatar'
export default {
    components: {
        // Avatar
    },
    data() {
        return {
            user: {},
            dialog: false,
        }
    },
    methods: {
        close() {
            this.dialog = false
        }
    },
    created() {
        eventBus.$on('openUserShow', data => {
            this.dialog = true
            this.user = data
        });
    },
}
</script>
