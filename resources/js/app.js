require('./bootstrap');

import VueRouter from 'vue-router';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

window.Vue = require('vue').default;
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueRouter);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('app-component', require('./components/App.vue').default);
Vue.component('tickets-component', require('./components/Tickets.vue').default);
Vue.component('add-ticket-component', require('./components/AddTicket.vue').default);
Vue.component('vueDropzone', require('vue2-dropzone'));


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
