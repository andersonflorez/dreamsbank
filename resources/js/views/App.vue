<template>
    <div>
        <v-app id="inspire">
            <MenuComponent v-if="this.authenticated" />
            <notifications group="alert" position="bottom right" />
            <v-main>
                <v-container fluid>
                    <router-view />
                </v-container>
            </v-main>
            <v-footer color="default" app>
                <span class="dark--text">&copy; 2020 Prueba de admision</span>
            </v-footer>
        </v-app>
    </div>
</template>

<script>
import MenuComponent from "../components/MenuComponent.vue";
import { mapGetters, mapActions } from "vuex";
export default {
    components: {
        MenuComponent
    },
    computed: {
        ...mapGetters({
            authenticated: "authStore/authenticated"
        })
    },
    created() {
        if (!this.authenticated) {
            this.$router.replace({ name: "Login" });
        }
    }
};
</script>
