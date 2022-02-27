import Vue from "vue"
import Index from './components/Index'
import router from './plugins/router'
import vuetify from './plugins/vuetify'
import store from './store';
import { abilitiesPlugin } from '@casl/vue';
import ability from './services/ability.service'
require('./bootstrap');
require('bootstrap/dist/css/bootstrap.min.css')
import Toasted from 'vue-toasted';
import titleComponent from './components/VueTitle';
import { BootstrapVueIcons } from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue-icons.min.css'

Vue.use(BootstrapVueIcons)

Vue.component('vue-title', titleComponent);

Vue.use(abilitiesPlugin, ability);


new Vue({
    el: '#app',
    router,
    store,
    vuetify,
    components: {
        Index
    },
});
