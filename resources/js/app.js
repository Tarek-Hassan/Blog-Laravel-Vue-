/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use (VueRouter)
import App from './components/App'
import Login from './components/Login'
import Register from './components/Register'
import Home from './components/Home'
import Articles from './components/Articles'

const router =new VueRouter({
    mode:'history',
    routes:[
        {
            path:'/',
            name:'home',
            component:Home
        },
        {
            path:'/login',
            name:'login',
            component:Login
        },
        {
            path:'/register',
            name:'register',
            component:Register
        },
        {
            path:'/articles',
            name:'articles',
            component:Articles,
            meta:{
                requiresAuth:true,
                is_user:true
            }
        },
    ]
})
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (localStorage.getItem('store.token') == null) {
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            })
        } else {
            let user = JSON.parse(localStorage.getItem('store.user'))
            if (to.matched.some(record => record.meta.is_admin)) {
                if (user.is_admin == 1) {
                    next()
                }
                else {
                    next({ name: 'articles' })
                }
            }
            else if (to.matched.some(record => record.meta.is_user)) {
                if (user.is_admin == 0) {
                    next()
                }
                else {
                    next({ name: 'admin' })
                }
            }
            next()
        }
    } else {
        next()
    }
})
// Vue.component('nav-component', require('./components/NavComponent.vue').default);
// Vue.component('articles-component', require('./components/ArticlesComponent.vue').default);
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
    el: '#app',
    components:{App},
    router,
});
