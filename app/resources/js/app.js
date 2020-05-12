/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'sidbar-menu',
    require('./components/menu/Menu.vue').default
);

Vue.component(
    'profile-info',
    require('./components/profile_info/ProfileInfo.vue').default
);

Vue.component(
    'client-info',
    require('./components/profile_info/ClientInfo.vue').default
);

Vue.component('personal-info',
    require('./components/profile_info/PersonalInfo.vue').default
);

Vue.component('address-info',
    require('./components/profile_info/AddressInfo.vue').default
);

Vue.component('user-management',
    require('./components/admin/User.vue').default
);

Vue.component('api-registration',
    require('./components/api/Apis.vue').default
);

Vue.component('welcome',
    require('./components/welcome/Welcome.vue').default
);

Vue.component('documentation',
    require('./components/documentation/Documentation.vue').default
);

Vue.component('document',
    require('./components/documentation/DocMd.vue').default
);

Vue.component('document',
    require('./components/documentation/DocMd.vue').default
);
Vue.component('api-subscription',
    require('./components/profile_info/Subscription.vue').default
);

Vue.component('subscribe-form',
    require('./components/profile_info/Subscription.vue').default
);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VueSidebarMenu from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VuejsDialog from 'vuejs-dialog';
import VuejsDialogMixin from 'vuejs-dialog/dist/vuejs-dialog-mixin.min.js'; // only needed in custom components

// include the default style
import 'vuejs-dialog/dist/vuejs-dialog.min.css';

import VueToast from 'vue-toast-notification';
// Import any of available themes
import 'vue-toast-notification/dist/theme-default.css';
//import 'vue-toast-notification/dist/dist/theme-sugar.css';

import Vuetify from 'vuetify';
Vue.use(Vuetify);

Vue.use(VueToast);

// Tell Vue to install the plugin.
Vue.use(VuejsDialog);

Vue.use(require('vue-resource'));

Vue.use(VueSidebarMenu);
// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),

});
