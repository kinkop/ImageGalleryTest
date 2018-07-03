/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');
window.Vue = require('vue');

import store from './store'
import router from './router'
import App from './AppContainer'
import VeeValidate from 'vee-validate';

Vue.use(VeeValidate);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// Add a request interceptor
window.axios.interceptors.request.use(function (config) {
  // Do something before request is sent
  const accessToken = _.get(store, 'state.user.access_token', null)
  if (accessToken) {
    config.headers['Authorization'] = 'Bearer ' + _.get(store, 'state.user.access_token');
  }

  return config;
}, function (error) {
  // Do something with request error
  return Promise.reject(error);
});


const app = new Vue({
  el: '#app',
  template: '<App />',
  components: {
    App
  },
  router,
  store
});


