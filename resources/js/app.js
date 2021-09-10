/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VueApexCharts from 'vue-apexcharts'
require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.use(VueApexCharts)
Vue.component('apexchart', VueApexCharts)
Vue.component('ordenes', require('./components/OrdenesComponent.vue').default);
Vue.component('tables', require('./components/TablesComponent.vue').default);
Vue.component('items', require('./components/ItemsComponent.vue').default);
Vue.component('item-form', require('./components/ItemFormComponent.vue').default);
Vue.component('charts', require('./components/ChartsComponent.vue').default);
Vue.component('item-edit-form', require('./components/ItemEditFormComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
