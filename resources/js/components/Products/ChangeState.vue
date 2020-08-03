<template>
    <div>
        <v-dialog v-model="dialog" persistent max-width="400">
            <v-card>
                <v-card-title class="headline"
                    ><p>Cambiar estado</p></v-card-title
                >

                <v-card-text>
                    Esta seguro de cambiar el estado de esta cuenta?
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn color="green darken-1" text @click="closeDialogState">
                        Cancelar
                    </v-btn>

                    <v-btn
                        color="blue darken-1"
                        text
                        @click="changeStateItem('denied')"
                    >
                        Denegar
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="changeStateItem('approved')"
                    >
                        Aprovar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
    data(){
        return {
            dialog: true
        }
    },
    props:{
        itemChange:{
            required: true,
            type: Object
        },
        closeDialogState:{
            type: Function
        }
    },
    methods: {
        ...mapActions({
            updateStore: "productStore/update"
        }),
        async changeStateItem(state) {
            const product = this.itemChange;
            product.state = state;
            await this.updateStore({product, id: this.itemChange.id}).then(res => {
                this.closeDialogState();
            });
        }
    }
};
</script>
