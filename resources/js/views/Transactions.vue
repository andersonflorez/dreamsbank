<template>
    <div>
        <div class="d-flex justify-start mb-6 align-center">
            <div class="text-h2" v-text="'Transacciones'"></div>
        </div>
        <v-divider />
        <TableTransactions />
    </div>
</template>

<script>
import TableTransactions from "../components/Transactions/TableTransactions.vue";

export default {
    name: "Transactions",
    components: {
        TableTransactions
    }
};
</script>
