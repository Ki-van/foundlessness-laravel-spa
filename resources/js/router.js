import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Home from './pages/Home';

const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'register',
        path: '/register',
        component: () => import('./pages/Register')
    },
    {
        name: 'login',
        path: '/login',
        component: () => import('./pages/Login')
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: () => import('./pages/Dashboard')
    }
];


export default new VueRouter({
    mode: "history",
    routes,
})
