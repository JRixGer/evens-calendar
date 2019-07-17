// app.js

require('./bootstrap');

window.Vue = require('vue');

import VueToastr2 from 'vue-toastr-2'
import 'vue-toastr-2/dist/vue-toastr-2.min.css'
window.toastr = require('toastr')
Vue.use(VueToastr2)

import VueAxios from 'vue-axios';
import axios from 'axios';

import EventComponent from './components/EventComponent.vue';
Vue.use(VueAxios, axios);

const app = new Vue(Vue.util.extend(EventComponent)).$mount('#app');