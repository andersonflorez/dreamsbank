<template>
    <v-card>
        <v-card-title>
            <span class="headline">Solicitar producto</span>
        </v-card-title>
        <v-card-text>
            <v-container>
                <v-row>
                    <v-col cols="12" sm="12">
                        <v-select
                            :items="[
                                'Credito Agil',
                                'Tarjeta de Crédito',
                                'Cuenta de Ahorros',
                                'Leasing de Vivienda'
                            ]"
                            label="Productos *"
                            required
                            v-model="form.name"
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
            <small>* Indica los campos obligatorios</small>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="closeModal"
                >Cancelar</v-btn
            >
            <v-btn color="green darken-1" text @click="createProduct"
                >Solicitar</v-btn
            >
        </v-card-actions>
    </v-card>
</template>

<script>
import { mapActions } from "vuex";

export default {
    name: "FormProducts",
    props: {
        closeModal: {
            type: Function
        },
        product: {
            type: Object,
            default() {
                return {
                    id: undefined,
                    name: "",
                    state: "pending"
                };
            }
        }
    },
    data() {
        return {
            form: this.product
        };
    },
    methods: {
        ...mapActions({
            createStore: "productStore/create"
        }),
        createProduct() {
            this.createStore(this.form).then(res => {
               this.closeModal();
            });
        }
    }
};
</script>
