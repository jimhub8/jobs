/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.eventBus = new Vue()
import VueRouter from 'vue-router'
import StoreData from './store/store'
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'
import 'element-ui/lib/theme-chalk/index.css';
// import '@fortawesome/fontawesome-free/css/all.css' // Ensure you are using css-loader
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import Vuetify from 'vuetify'

import Vuex from 'vuex';
Vue.use(Vuetify)

Vue.use(Vuex);

// create Vuex store, if you don't have it
// const store = new Vuex.Store();
const store = new Vuex.Store(StoreData)



import VueGoodTablePlugin from 'vue-good-table';

// import the styles
import 'vue-good-table/dist/vue-good-table.css'

Vue.use(VueGoodTablePlugin);

// import VueCharts from 'vue-chartjs'
// import { Bar, Line } from 'vue-chartjs'
// import BootstrapVue from 'bootstrap-vue'
// import VueBarcode from '@chenfengyuan/vue-barcode';

// import Chartkick from 'vue-chartkick'
// import Chart from 'chart.js'
// Vue.use(Chartkick.use(Chart))

// Vue.component(VueBarcode.name, VueBarcode);
// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'


// Vue.use(BootstrapVue)
Vue.use(VueRouter)
Vue.use(Vuex)
Vue.use(ElementUI, { locale });
import 'vuetify/dist/vuetify.min.css'

// const store = new Vuex.Store(StoreData)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import myHeader from './components/include/HeadView'
import myDashboard from './components/Dashboard';
import myUser from './components/users/User';
import myRoles from './components/users/roles/Roles';
import myClient from './components/client/Client.vue';
import myStatus from './components/selects/status';
import myJobs from './components/jobs/Jobs';
import myLeads from './components/leads';
import myReports from './components/report/Report';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const routes = [
    { path: '/', component: myDashboard },
    { path: '/users', component: myUser },
    { path: '/roles', component: myRoles },
    { path: '/clients', component: myClient },
    { path: '/status', component: myStatus },
    { path: '/jobs', component: myJobs },
    { path: '/leads', component: myLeads },
    { path: '/reports', component: myReports },

]
const router = new VueRouter({
    // mode: 'history',
    routes // short for `routes: routes`
})
// var csrf_token = $('meta[name="csrf-token"]').attr('content');

const app = new Vue({
    el: '#app',
    // token: csrf_token,
    // vuetify,
    vuetify: new Vuetify(),
    store,
    router,
    components: {
        myHeader, myUser, myClient, myStatus, myJobs, myLeads, myReports
        // myTest
    },



});
