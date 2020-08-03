<template>
    <v-card class="elevation-12">
        <v-toolbar color="default" dark flat>
            <v-toolbar-title>Login</v-toolbar-title>
            <v-tooltip />
        </v-toolbar>
        <v-card-text>
            <v-form>
                <v-text-field
                    label="Cedula"
                    name="document"
                    prepend-icon="mdi-account"
                    type="text"
                    v-model="form.document"
                ></v-text-field>

                <v-text-field
                    id="password"
                    label="Contraseña"
                    name="password"
                    prepend-icon="mdi-lock"
                    type="password"
                    v-model="form.password"
                ></v-text-field>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-btn @click="submit" block large color="grey darken-4" dark>Login</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
import axios from "axios";
import { mapActions } from "vuex";

export default {
    name: "FormLogin",
    data() {
        return {
            form: {
                document: "",
                password: ""
            }
        };
    },

    methods: {
        ...mapActions({
            login: "authStore/login"
        }),

        async submit() {
            const login = await this.login(this.form);
            if (login) this.$router.replace({ name: "Home" });
        }
    }
};
</script>
