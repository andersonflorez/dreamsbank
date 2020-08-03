import ProductService from "../../services/productService";

interface IState {
    products: {
        items: Array<IProduct>;
        total: Number;
        loading: boolean;
        options: any;
    };
}

export default {
    namespaced: true,

    state: {
        products: {
            items: [],
            total: 0,
            loading: false,
            options: {}
        }
    },

    getters: {
        items(state: IState) {
            return state.products.items;
        },
        total(state: IState) {
            return state.products.total;
        },
        loading(state: IState) {
            return state.products.loading;
        },
        options(state: IState) {
            return state.products.options;
        }
    },

    mutations: {
        SET_ITEMS(state: IState, value: Array<IProduct>) {
            state.products.items = value;
        },
        SET_ITEM(state: IState, value: IProduct) {
            state.products.items.unshift(value);
        },
        SET_TOTAL(state: IState, value: Number) {
            state.products.total = value;
        },
        SET_LOADING(state: IState, value: boolean) {
            state.products.loading = value;
        },
        SET_OPTIONS(state: IState, value: any) {
            state.products.options = value;
        }
    },

    actions: {
        async create({ dispatch, getters }: any, product: IProduct) {
            await ProductService.create(product);
            await dispatch("getAllData", getters.options);
            return true;
        },
        async getAllData({ commit }: any, options: any) {
            commit("SET_LOADING", true);
            commit("SET_OPTIONS", options);
            const response = await ProductService.getAllData(options);
            commit("SET_ITEMS", response.data);
            commit("SET_TOTAL", response.count);
            commit("SET_LOADING", false);
            return true;
        },
        async delete({ dispatch, getters }: any, id: Number) {
            await ProductService.delete(id);
            await dispatch("getAllData", getters.options);
            return true;
        },
        async update({ dispatch, getters }: any, { product, id }: any) {
            await ProductService.update(product, id);
            await dispatch("getAllData", getters.options);
            return true;
        }
    }
};
