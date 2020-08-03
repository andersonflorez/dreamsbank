<template>
    <v-main>
        <v-container class="fill-height" fluid>
            <v-row align="center" justify="center">
                <v-col cols="12" sm="8" md="4">
                    <FormLogin />
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>
import FormLogin from "../components/FormLogin.vue";

export default {
    name: "Login",
    components: {
        FormLogin
    }
};
</script>
