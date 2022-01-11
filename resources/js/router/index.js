import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Home from '../pages/Home';


export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'register',
        path: '/register',
        component: () => import('../pages/Register')
    },
    {
        name: 'login',
        path: '/login',
        component: () => import('../pages/Login')
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: () => import('../pages/Dashboard')
    }
];

const router = new VueRouter({
    mode: 'history',
   // base: process.env.BASE_URL,
    routes
})
export default router
