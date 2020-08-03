import AuthService from "../../services/authService";

export default {
    namespaced: true,

    state: {
        authenticated: false,
        user: null
    },

    getters: {
        authenticated(state: any) {
            return state.authenticated;
        },
        user(state: any) {
            return state.user;
        }
    },

    mutations: {
        SET_AUTHENTICATED(state: any, value: any) {
            state.authenticated = value;
        },

        SET_USER(state: any, value: any) {
            state.user = value;
        }
    },

    actions: {
        async login({ dispatch }: any, credentials: any) {
            await AuthService.login(credentials);
            return dispatch("me");
        },

        async logout({ commit }: any) {
            await AuthService.logout();
            commit("SET_AUTHENTICATED", false);
            commit("SET_USER", null);
            return true;
        },

        me({ commit }: any): any {
            return AuthService.authUser()
                .then(response => {
                    commit("SET_AUTHENTICATED", true);
                    commit("SET_USER", response.data);
                    return true;
                })
                .catch(() => {
                    commit("SET_AUTHENTICATED", false);
                    commit("SET_USER", null);
                    return false;
                });
        }
    }
};
