require('./bootstrap');
require('./prototypes');

import router from './router'
import store from './store'

import Vue from 'vue'
import Vuetify from 'vuetify'
import axios from 'axios'
import VeeValidate, {Validator} from 'vee-validate';
import ptBr from 'vee-validate/dist/locale/pt_BR.js';

// Helpers
import colors from 'vuetify/es5/util/colors'

Vue.use(Vuetify, {
    theme: {
        primary: colors.red.darken3
    }
});


import money from 'v-money'

// register directive v-money and component <money>
Vue.use(money);


Validator.localize('pt_BR', ptBr);
Vue.use(VeeValidate, {locale: 'pt_BR'});

import App from './components/AppComponent'

axios.interceptors.response.use(function (response) {
    let new_token = response.headers['new_token'];
    if (new_token) {
        store.dispatch('auth/updateToken', new_token)
    }
    if(response.status === 401 && response.headers['WWW-Authenticate'] === 'jwt_auth'){
        store.dispatch('auth/logout')
    }
    store.commit('progressBar', 100);
    setTimeout(()=>{
        store.commit('showProgressBar', false);
    }, 1000);
    return response;
});

window.axios.interceptors.request.use(function (request) {
    if(!store.state.utils.showProgressBar){
        store.commit('showProgressBar', true);
        store.commit('progressBar', 20);
    }
    return request;
});

window.axios.defaults.onUploadProgress = progressEvent => {
    let percentCompleted = Math.floor((progressEvent.loaded * 100) / progressEvent.total);
    store.commit('progressBar', percentCompleted)
};
Vue.config.devtools = true;
Vue.config.performance = true;
const app = new Vue({
    store,
    router,
    el: '#app',
    render: h => h(App)
});