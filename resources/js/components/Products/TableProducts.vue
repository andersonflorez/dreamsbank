<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="products"
            :options.sync="options"
            :server-items-length="totalProducts"
            :loading="loading"
            class="elevation-1"
        >
            <template v-slot:item.state="{ item }">
                <v-chip :color="getColor(item.state)" dark>{{
                    item.state_spanish
                }}</v-chip>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon v-if="user.role == 'admin'" @click="openDialogState(item)">
                    mdi-lock
                </v-icon>
                <v-icon @click="openDialogDelete(item)">
                    mdi-delete
                </v-icon>
            </template>
        </v-data-table>
        <v-dialog persistent v-model="dialog" max-width="290">
            <v-card>
                <v-card-title class="headline"
                    ><p>Eliminar cuenta</p></v-card-title
                >

                <v-card-text>
                    Esta seguro de eliminar esta cuenta?
                    </br></br>
                    Al eliminarla, se eliminaran todas las
                    transacciones asociadas.
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn color="green darken-1" text @click="closeDialogDelete">
                        Cancelar
                    </v-btn>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="deleteItem()"
                    >
                        Aceptar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <ChangeState v-if="dialogState" :itemChange="itemChange" :closeDialogState="closeDialogState"/>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import ChangeState from './ChangeState.vue';

export default {
    data() {
        return {
            itemChange: {},
            dialog: false,
            dialogState: false,
            options: {}
        };
    },
    components:{
        ChangeState
    },
    computed: {
        ...mapGetters({
            products: "productStore/items",
            totalProducts: "productStore/total",
            loading: "productStore/loading",
            user: "authStore/user"
        }),
        headers(){
            const headers = [
                {
                    text: "Nombre",
                    align: "start",
                    value: "name"
                },
                {
                    text: "Numero",
                    align: "start",
                    value: "number"
                },
                {
                    text: "Fecha Solicitud",
                    align: "start",
                    value: "created_at"
                },
                {
                    text: "Estado",
                    align: "start",
                    value: "state"
                },
                {
                    text: "Actions",
                    align: "start",
                    value: "actions",
                    sortable: false
                }
            ]

            if(this.user.role == 'admin'){
                headers.unshift({
                    text: 'Cliente',
                    align: 'start',
                    value: 'user.name',
                    sortable: false
                });
            }
            return headers;
        }
    },
    watch: {
        options: {
            async handler() {
                await this.getDataStore(this.options);
            },
            deep: true
        }
    },
    methods: {
        ...mapActions({
            getDataStore: "productStore/getAllData",
            deleteStore: "productStore/delete"
        }),

        getColor(state) {
            if (state == "pending") {
                return "orange";
            } else if (state == "approved") {
                return "green";
            } else {
                return "red";
            }
        },
        openDialogDelete(item) {
            this.itemChange = item;
            this.dialog = true;
        },
        closeDialogDelete(){
            this.itemChange = {};
            this.dialog = false;
        },
        openDialogState(item) {
            this.itemChange = item;
            this.dialogState = true;
        },
        closeDialogState(){
            this.itemChange = {};
            this.dialogState = false;
        },
        async deleteItem() {
            await this.deleteStore(this.itemChange.id).then(res => {
                this.closeDialogDelete();
            });
        }
    }
};
</script>
