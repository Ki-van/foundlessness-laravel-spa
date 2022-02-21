import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Home from '../pages/Home';
import Admin from '../components/Admin'

const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'profile',
        path: '/profile',
        component: () => import('../pages/Profile')
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
        path: '/admin',
        component: Admin,
        meta: {
          layout: 'empty'
        },
        children: [
            {
                path: 'users',
                component: () => import('../pages/Users')
            },
            {
                path: 'roles',
                component: () => import('../pages/Roles')
            },
            {
                path: 'permissions',
                component: () => import('../pages/Permissions')
            },
            {
                path: 'settings',
                component: () => import('../pages/Settings')
            },
            {
                path: 'activities',
                component: () => import('../pages/Activities')
            }
        ]
    }
];


export default new VueRouter({
    mode: "history",
    routes,
})
