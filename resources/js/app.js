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
import {ValidationProvider, ValidationObserver} from "vee-validate";

Vue.use(BootstrapVueIcons)
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('vue-title', titleComponent);

Vue.use(abilitiesPlugin, ability);
Vue.use(Toasted);

new Vue({
    el: '#app',
    router,
    store,
    vuetify,
    components: {
        Index
    },
});
