require('./bootstrap');

import BootstrapVue from 'bootstrap-vue'
window.Vue = require('vue');

Vue.component('board-component', require('./components/BoardComponent.vue').default);
Vue.component('cell-component', require('./components/CellComponent.vue').default);
Vue.component('matrix-component', require('./components/MatrixComponent.vue').default);
Vue.use(BootstrapVue)

const app = new Vue({
    el: '#app'
});