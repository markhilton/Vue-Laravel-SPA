require('./bootstrap');

import Vue       from 'vue';
import Vuex      from 'vuex';
import Vuetify	 from 'vuetify'
import VueRouter from 'vue-router';
import colors	 from 'vuetify/es5/util/colors' // https://vuetifyjs.com/en/style/colors
import {routes}  from './routes';
import StoreData from './store';
import App       from '../components/App.vue';
import {initialize} from './helpers/general';
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)
Vue.use(VueRouter);
Vue.use(Vuex);

const store  = new Vuex.Store(StoreData);
const router = new VueRouter({
    routes,
    mode: 'history'
});

initialize(store, router);

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        App
    }
});
