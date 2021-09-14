require('./bootstrap');

import VueRouter from 'vue-router';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap-vue/dist/bootstrap-vue.css';

window.Vue = require('vue').default;
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueRouter);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('tickets-component', require('./components/Tickets.vue').default);
Vue.component('add-ticket-component', require('./components/AddTicket.vue').default);
Vue.component('comment-form-component', require('./components/CommentForm.vue').default);
Vue.component('add-user-component', require('./components/AddUser.vue').default);
Vue.component('users-component', require('./components/Users.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
