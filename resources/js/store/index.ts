import Vue from "vue";
import Vuex from "vuex";
import authStore from "./modules/authStore";
import productStore from "./modules/productStore";
import transactionStore from "./modules/transactionStore";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        authStore,
        productStore,
        transactionStore
    }
});
