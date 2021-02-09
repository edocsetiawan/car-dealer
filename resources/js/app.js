/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'

import VueRouter from 'vue-router';
import App from './App.vue';
import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueRouter);
Vue.use(VueAxios, axios);

import LoginComponent from './components/Login.vue';
import LandingComponent from './components/LandingPage.vue';
import RegisterComponent from './components/RegisterPage.vue';
import CarComponent from './components/NewCar.vue';
import TransasctionComponent from './components/NewTransaction.vue';

const routes = [
    {
        name : 'login',
        path: '/',
        component : LoginComponent
    },
    {
        name : 'landingpage',
        path: '/landingpage',
        component : LandingComponent
    },
    {
        name : 'register',
        path : '/register',
        component : RegisterComponent
    },
    {
        name: 'car',
        path: '/add-new-car',
        component : CarComponent
    },
    {
        name: 'transaction',
        path: '/add-new-transaction',
        component : TransasctionComponent
    }

]
const router = new VueRouter({ mode: 'history', routes: routes});
const app = new Vue(Vue.util.extend({ router }, App)).$mount('#app');