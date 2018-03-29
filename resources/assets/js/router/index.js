import Vue from 'vue'
import VueRouter from 'vue-router'

import routes from './routes'
import store from '../store'
import {NAME_TOKEN} from '../config'

Vue.use(VueRouter);

const router = new VueRouter({
    routes,
    mode: 'history'
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem(NAME_TOKEN);

    if(!to.name){
        next({name: '404'});
        return;
    }
    if(typeof to.meta.auth === 'undefined'){
        next();
        return;
    }

    if (to.meta.auth && !store.state.auth.authenticated && !token) {

        return router.push({name: 'login'})

    }
    if (!to.meta.auth && (store.state.auth.authenticated || token)) {

        checkHasTokenAndIsUnauthenticated(token);

        return router.push({name: 'dashboard'})

    }

    checkHasTokenAndIsUnauthenticated(token);

    next();

});

function checkHasTokenAndIsUnauthenticated(token){
    if (store.state.auth.authenticated && token) {
        return;
    }

    if (!store.state.auth.authenticated && !token) {
        return;
    }

    store.dispatch('auth/updateStatus', true);

    store.dispatch('auth/checkLogin').then(() => {
    }).catch(() => {
        router.push({name: 'login'});
    });

}

export default router