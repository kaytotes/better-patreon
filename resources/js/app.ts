import './bootstrap';
import Vue from 'vue';

import './generic'

/* Login Component */
import LoginComponent from './components/Auth/Login.vue';
Vue.component('login', LoginComponent);

/* Instantiate Vue */
new Vue({
    el: '#app'
});