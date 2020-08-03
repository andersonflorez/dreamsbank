<template>
    <div>
        <div class="d-flex justify-start mb-6 align-center">
            <div class="text-h2" v-text="'Productos'"></div>
            <v-btn color="default" dark @click="openModal" class="ml-8">
                Solicitar producto
            </v-btn>
            <v-dialog v-model="dialog" persistent max-width="600px">
                <FormProducts :closeModal="this.closeModal"/>
            </v-dialog>
        </div>
        <v-divider />
        <TableProducts />
    </div>
</template>

<script>
import TableProducts from "../components/Products/TableProducts.vue";
import FormProducts from "../components/Products/FormProducts.vue";

export default {
    name: "Products",
    components: {
        FormProducts,
        TableProducts
    },
    data: () => ({
        dialog: false
    }),
    methods:{
        closeModal(){
            this.dialog = false
        },
        openModal(){
            this.dialog = true
        }
    }
};
</script>
