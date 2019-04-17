
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/*window.Vue = require('vue');*/

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*import {TinkerComponent} from 'botman-tinker';
Vue.component('botman-tinker', TinkerComponent);

const app = new Vue({
    el: '#app'
});*/

/*import $ from 'jquery';
window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker.js';


$('.datepicker').datepicker(
    { dateFormat: 'DD, d MM, yy' }
);

import 'jquery-ui/ui/widgets/autocomplete.js';
*/


window.Vue = require('vue');
import axios from 'axios';
//window.axios = axios;

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
    'Authorization': 'Bearer ' + Laravel.apiToken,
};

window.Vue.prototype.$http = axios;


Vue.component('bookingdate', require('./components/BookingDate.vue'));
Vue.component('selectuser', require('./components/SelectUser.vue'));

const app = new Vue({
    el: '#app'
});

import VueSelect from 'vue-cool-select'

Vue.use(VueSelect, {
    theme: 'bootstrap' // or 'material-design'
})
