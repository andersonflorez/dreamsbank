import Vue from "vue";
import Router from "vue-router";
import Products from "../views/Products.vue";
import Transactions from "../views/Transactions.vue";
import Login from "../views/Login.vue";
import store from "../store";

Vue.use(Router);
const state: any = store.state;
const router = new Router({
    mode: "history",
    routes: [
        { path: '/', redirect: '/products' },
        {
            path: "/products",
            name: "Products",
            component: Products
        },
        {
            path: "/transactions",
            name: "Transactions",
            component: Transactions
        },
        {
            path: "/login",
            name: "Login",
            component: Login,
            beforeEnter(to, from, next) {
                if (state.authStore.authenticated) {
                    next(false);
                } else {
                    next();
                }
            }
        }
    ]
});

export default router;
