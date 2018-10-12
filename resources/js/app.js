require('./bootstrap');

import Vue       from 'vue';
import Vuex      from 'vuex';
import Vuetify	 from 'vuetify'
import VueRouter from 'vue-router';
import Echo      from 'laravel-echo';
import Pusher    from 'pusher-js';
import colors	 from 'vuetify/es5/util/colors'; // https://vuetifyjs.com/en/style/colors
import {routes}  from './routes';
import StoreData from './store';
import App       from '../components/App.vue';
import {initialize} from './helpers/general';
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(Vuex);

/*
 * pusher & echo
 *
 */

// push notifications
window.Pusher.logToConsole = true;
window.pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY);

window.Echo = new Echo({
    broadcaster: 'pusher',
    key:         process.env.MIX_PUSHER_APP_KEY,
    cluster:     'mt1',
    encrypted:   true
});


// Vuex store
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
