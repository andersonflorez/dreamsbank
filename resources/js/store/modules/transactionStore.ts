import TransactionService from "../../services/transactionService";

interface IState {
    transactions: {
        items: Array<ITransaction>;
        total: Number;
        loading: boolean;
        options: any;
    };
    productsApproved: Array<any>;
}

export default {
    namespaced: true,

    state: {
        transactions: {
            items: [],
            total: 0,
            loading: false,
            options: {}
        },
        productsApproved: []
    },

    getters: {
        items(state: IState) {
            return state.transactions.items;
        },
        total(state: IState) {
            return state.transactions.total;
        },
        loading(state: IState) {
            return state.transactions.loading;
        },
        options(state: IState) {
            return state.transactions.options;
        },
        productsApproved(state: IState) {
            return state.productsApproved;
        }
    },

    mutations: {
        SET_ITEMS(state: IState, value: Array<ITransaction>) {
            state.transactions.items = value;
        },
        SET_ITEM(state: IState, value: ITransaction) {
            state.transactions.items.unshift(value);
        },
        SET_TOTAL(state: IState, value: Number) {
            state.transactions.total = value;
        },
        SET_LOADING(state: IState, value: boolean) {
            state.transactions.loading = value;
        },
        SET_OPTIONS(state: IState, value: any) {
            state.transactions.options = value;
        },
        SET_PRODUCTS(state: IState, value: Array<any>) {
            state.productsApproved = value;
        }
    },

    actions: {
        async getAllData({ commit, getters }: any, options: any) {
            commit("SET_OPTIONS", options);
            console.log(getters.options.product_id);
            commit("SET_LOADING", true);
            const response = await TransactionService.getAllData(options);
            commit("SET_ITEMS", response.data);
            commit("SET_TOTAL", response.count);
            commit("SET_LOADING", false);
            return true;
        },
        async getProductsApproved({ commit }: any) {
            const response = await TransactionService.getProductsApproved();
            const products = response.products.map((item: any, index: any) => {
                return {
                    value: item.id,
                    text: `${item.name} - ${item.number}`
                };
            });
            commit("SET_PRODUCTS", products);
            return true;
        }
    }
};
