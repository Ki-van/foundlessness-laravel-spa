import AuthService from '../services/auth.service';
import axios from "axios";
import { AbilityBuilder, Ability } from '@casl/ability'

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
    getters: {
        user (state) {
            return state.user;
        }
    },
    actions: {
        login({commit}, credentials) {
            return AuthService.login(credentials).then(
                response => {
                    if(response.status === 422) {
                        commit('loginFailure')
                        return Promise.reject('Пользователь или пароль неверен')
                    }

                    commit('loginSuccess', response.data.data);
                    return Promise.resolve(response.data.data);
                },
                error => {
                    commit('loginFailure');
                    return Promise.reject(error);
                }
            );
        },
        logout({commit}) {
            return AuthService.logout().then(
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
            return AuthService.register(user)
                .catch(function (error) {
                console.log('Module error', error);
                commit('registerFailure');
                return Promise.reject(error.response);
            }).then(function (response) {
                    if (response.status === 422)
                        return Promise.reject(response.data);
                    console.log('register success');
                    commit('registerSuccess');
                    return Promise.resolve(response.data);
                })
        }
    },
    mutations: {
        loginSuccess(state, user) {
            state.user = user;
            const { can, rules } = new AbilityBuilder(Ability);
            if (user.roles[0] === 'Admin') {
                can('manage', 'all');
            } else {
                user.roles.forEach(role => role.permissions.forEach(permission => can(permission.name, 'all')))
            }
            this._vm.$ability.update(rules);
            state.status.loggedIn = true;
            console.log(this._vm.$ability.rules);
        },
        addArticle(state, article) {
            state.user.articles.push(article);
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
