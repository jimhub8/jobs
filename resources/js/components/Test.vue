<template>
    <v-content>
        <v-container fluid fill-height>
            <v-layout justify-center align-center>
                <file-manager></file-manager>
            </v-layout>
        </v-container>
    </v-content>
</template>

<script>
export default {
    mounted() {
        // console.log('Component mounted.')
    }
};
</script>

<style scoped>
.fm .fm-body {
    height: 500px !important;
}
</style>
