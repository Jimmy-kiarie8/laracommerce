
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import 'w3-css/w3.css';

// import 'mdi-vue/CommentAlertIcon';

// require('mdi-vue/HotelIcon');

// vuetify
Vue.use(Vuetify)

// vue Routes
Vue.use(VueRouter)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



let myView = require('./components/view/View.vue');
let myBrand = require('./components/brand/Brand.vue');
let myCategory = require('./components/category/Category.vue');
let myProduct = require('./components/product/Product.vue');
let myUsers = require('./components/users/User.vue');
let myprofile = require('./components/users/Profile.vue');

const routes = [
	{path: '/', component: myView },
	{path: '/brands', component: myBrand },
	{path: '/categories', component: myCategory },
    {path: '/products', component: myProduct },
    {path: '/users', component: myUsers },
	{path: '/profile', component: myprofile },
]

const router = new VueRouter({
	// mode: 'history',
  	routes // short for `routes: routes`
 })

const app = new Vue({
    el: '#app',
    router,
    components: {
    	myView, myBrand, myCategory, myProduct, myUsers, myprofile
    },
});
