/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

import store from './store/index'; //import Vuex Store
import ElementUI from 'element-ui'; //import ElementUI pop-up modal window
import 'element-ui/lib/theme-chalk/index.css'; //moved as sepearate CSS Fileto css in /layout/app.php

Vue.use(ElementUI); //connect Vue to use with ElementUI

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component',     require('./components/ExampleComponent.vue').default);
Vue.component('owners-list-component', require('./components/OwnersListComponents/GetOwnersListComponent.vue').default); //register component (default is a must fix)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
	store,
    el: '#app',
});



