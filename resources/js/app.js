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


Vue.use(Toasted, {
    iconPack : 'material'
});

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
