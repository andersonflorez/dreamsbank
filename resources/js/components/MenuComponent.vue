<template>
    <v-navigation-drawer permanent app color="default" dark>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title class="title">
                    Banco de los sueños
                </v-list-item-title>
                <v-list-item-subtitle>
                    {{ user.name }}
                </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>

        <v-list dense nav>
            <v-list-item link to="/products">
                <v-list-item-icon>
                    <v-icon>mdi-widgets</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Productos</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item link to="/transactions">
                <v-list-item-icon>
                    <v-icon>mdi-cash-multiple</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>Transacciones</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
        <template v-slot:append>
            <div class="pa-2">
                <v-btn block @click.prevent="logout">Salir</v-btn>
            </div>
        </template>
    </v-navigation-drawer>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    computed: {
        ...mapGetters({
            user: "authStore/user"
        })
    },

    methods: {
        ...mapActions({
            logoutAction: "authStore/logout"
        }),

        async logout() {
            await this.logoutAction();

            this.$router.replace({ name: "Login" });
        }
    }
};
</script>
