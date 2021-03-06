
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'

require('./bootstrap');

Vue.use(VueRouter)
Vue.component('navbar', require('./components/Layouts/Navbar.vue'))


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: require('./components/About.vue') },
        { path: '/tasks', component: require('./components/tasks/Index.vue') },
        { path: '/entries', component: require('./components/entries/Index.vue') },
    ]
})

Vue.config.devtools = false;

const app = new Vue({
    router,
    el: '#app'
});
