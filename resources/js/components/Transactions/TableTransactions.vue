<template>
    <div>
        <v-col class="d-flex" cols="12" sm="6">
            <v-select
                v-model="productFilter"
                :items="productsApproved"
                label="Producto"
            ></v-select>
        </v-col>
        <v-data-table
            :headers="headers"
            :items="transactions"
            :options.sync="options"
            :server-items-length="totalTransactions"
            :loading="loading"
            class="elevation-1"
        >
        </v-data-table>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    data() {
        return {
            productFilter: undefined,
            options: { product_id: undefined },
            headers: [
                {
                    text: "Producto",
                    align: "start",
                    value: "product_text",
                    sortable: false
                },
                {
                    text: "Comercio",
                    align: "start",
                    value: "commerce"
                },
                {
                    text: "Fecha transacción",
                    align: "start",
                    value: "created_at"
                },
                {
                    text: "Estado",
                    align: "start",
                    value: "state"
                },
                {
                    text: "Monto",
                    align: "start",
                    value: "amount",
                }
            ]
        };
    },
    computed: {
        ...mapGetters({
            transactions: "transactionStore/items",
            totalTransactions: "transactionStore/total",
            loading: "transactionStore/loading",
            productsApproved: "transactionStore/productsApproved"
        })
    },
    watch: {
        options: {
            async handler() {
                if (this.productFilter != undefined) {
                    await this.getDataStore({
                        ...this.options,
                        product_id: this.productFilter
                    });
                }
            },
            deep: true
        },
        productFilter: {
            async handler() {
                if (this.productFilter != undefined) {
                    await this.getDataStore({
                        ...this.options,
                        product_id: this.productFilter
                    });
                }
            }
        }
    },
    mounted() {
        this.getProductsApprovedStore();
    },
    methods: {
        ...mapActions({
            getDataStore: "transactionStore/getAllData",
            getProductsApprovedStore: "transactionStore/getProductsApproved"
        })
    }
};
</script>
