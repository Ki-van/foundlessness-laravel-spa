import Vue from "vue"
import Index from './components/Index'
import router from './plugins/router'
import vuetify from './plugins/vuetify'
import store from './store';


require('./bootstrap');
require('bootstrap/dist/css/bootstrap.min.css')


new Vue({
    el: '#app',
    router,
    vuetify,
    store,
    components: {
        Index
    },
});
