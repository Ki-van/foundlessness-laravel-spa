require('./bootstrap');

window.Vue = require('vue').default;

import App from "./App.vue";
import Router from './router'
import Vuex from 'vuex'

new Vue({
    Router,
    Vuex,
    render: h => h(App)
}).$mount('#app')
