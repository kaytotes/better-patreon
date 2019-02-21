import './bootstrap';
import Vue from 'vue';

/* Login Component */
import LoginComponent from './components/Auth/Login.vue';
Vue.component('login', LoginComponent);

/* Instantiate Vue */
new Vue({
    el: '#app'
});