import Vue from "vue"
import Auth from './auth'
import Index from './components/Index'
import router from './plugins/router'
import vuetify from './plugins/vuetify'
import store from './store';
//import VeeValidate from 'vee-validate';

require('./bootstrap');
require('bootstrap/dist/css/bootstrap.min.css')
//Vue.prototype.$auth = new Auth(window.user);
//Vue.use(VeeValidate);

new Vue({
    el: '#app',
    router,
    vuetify,
    store,
    components: {
        Index
    },
});
