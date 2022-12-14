/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import FullpageModal from 'vue-fullpage-modal'
Vue.use(FullpageModal)

import Vuesax from 'vuesax';
import 'vuesax/dist/vuesax.css';
import 'material-icons/iconfont/material-icons.css';
Vue.use(Vuesax);


import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
Vue.use(Toast);

import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css'
Vue.use(VueGoodTablePlugin);

import VueDateFns from "vue-date-fns";
Vue.use(VueDateFns);

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

import money from 'v-money'
Vue.use(money, { precision: 3 })

import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)

import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css';
Vue.component('multiselect', Multiselect)

import VueFileAgent from 'vue-file-agent';
import 'vue-file-agent/dist/vue-file-agent.css';
Vue.use(VueFileAgent);

window.eventBus = new Vue();


Vue.component('shop-component', require('./components/Shop.vue').default);
Vue.component('admin-component', require('./components/Admin.vue').default);
Vue.component('sales-component', require('./components/Sales.vue').default);
Vue.component('upload-picture-component', require('./components/UploadPicture.vue').default);


const app = new Vue({
    el: '#app',
});
