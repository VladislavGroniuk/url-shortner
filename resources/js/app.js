require('./bootstrap');

import Vue from 'vue'

Vue.component('link-create-form-component', require('./components/home/LinkCreateFormComponent').default)

const app = new Vue({
    el: '#app'
})
