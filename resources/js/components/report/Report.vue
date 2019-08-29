<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center wrap>
            <v-layout row wrap style="margin-top: 140px;">
                <v-flex sm4 offset-sm1>
                    <Product></Product>
                </v-flex>
                <v-flex sm4 offset-sm1>
                    <Marketing></Marketing>
                </v-flex>
            </v-layout>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
import Product from './report/Product';
import Marketing from './report/Marketing';
export default {
    components: {
        Product, Marketing
    },
}
</script>

<style>

</style>
