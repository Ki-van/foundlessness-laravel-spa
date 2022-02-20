import AuthService from '../services/auth.service';

const user = window.user;
const initialState = user ?
    {
        status: {
            loggedIn: true
        },
        user
    } :
    {
        status: {
            loggedIn: false
        },
        user: null
    };
export const auth = {
    namespaced: true,
    state: {...initialState},
    actions: {
        login({commit}, credentials) {
             return AuthService.login(credentials).then(
                user => {
                    commit('loginSuccess', user);
                    return Promise.resolve(user);
                },
                error => {
                    commit('loginFailure');
                    return Promise.reject(error);
                }
            );
        },
        logout({commit}) {
            AuthService.logout().then(
                response => {
                    commit('logout', response);
                    return Promise.resolve(response);
                },
                error => {
                    return Promise.reject(error);
                }
            );
        },
        register({commit}, user) {
            return AuthService.register(user).then(
                response => {
                    commit('registerSuccess');
                    return Promise.resolve(user);
                },
                error => {
                    commit('registerFailure');
                    return Promise.reject(error);
                }
            );
        }
    },
    mutations: {
        loginSuccess(state, user) {
            state.user = user;
            state.status.loggedIn = true;
        },
        loginFailure(state) {
            state.status.loggedIn = false;
            state.user = null;
        },
        logout(state) {
            state.status.loggedIn = false;
            state.user = null;
        },
        registerSuccess(state) {
            state.status.loggedIn = false;
        },
        registerFailure(state) {
            state.status.loggedIn = false;
        }
    }
};
