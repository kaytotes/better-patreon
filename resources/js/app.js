
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/* Authentication */
Vue.component('login', require('./components/Auth/Login.vue').default);

/* Instantiate Vue */
const app = new Vue({
    el: '#app'
});
