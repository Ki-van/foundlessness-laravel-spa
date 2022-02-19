import AuthService from '../services/auth.service';

const token = localStorage.getItem('x_xsrf_token');
const initialState = token ?
    {
        status: {
            loggedIn: true
        },
        token
    } :
    {
        status: {
            loggedIn: false
        },
        token: null
    };
export const auth = {
    namespaced: true,
    state: {...initialState, user: null},
    actions: {
        login({commit}, credentials) {
             return AuthService.login(credentials).then(
                userInfo => {
                    console.log( "Action login auth module: ", userInfo);
                    commit('loginSuccess', userInfo);
                    return Promise.resolve(userInfo);
                },
                error => {
                    commit('loginFailure');
                    return Promise.reject(error);
                }
            );
        },
        getUserData({commit}) {
            return axios.p
        },
        logout({commit}) {
            AuthService.logout();
            commit('logout');
        },
        register({commit}, token) {
            return AuthService.register(token).then(
                response => {
                    commit('registerSuccess');
                    return Promise.resolve(token);
                },
                error => {
                    commit('registerFailure');
                    return Promise.reject(error);
                }
            );
        }
    },
    mutations: {
        loginSuccess(state, userInfo) {
            console.log('Login success user info: ',userInfo);
            state.token = userInfo.token;
            state.user = userInfo.user;
            state.status.loggedIn = true;
        },
        loginFailure(state) {
            state.status.loggedIn = false;
            state.token = null;
            state.user = null;
        },
        logout(state) {
            state.status.loggedIn = false;
            state.token = null;
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
