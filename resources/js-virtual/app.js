require('./bootstrap');
import Vue from 'vue';

window.Vue = require('vue').default;

// Vue.component('SfUsuarios', require('./components/Usuarios/Usuarios.vue').default);

Vue.component('SfTramiteVirtual', require('./components/Tramite/Tramite.vue').default);
Vue.component('SfBuscarQr', require('./components/BuscarQr/BuscarQr.vue').default);
Vue.component('SfLoader', require('./Helpers/Loader.vue').default);

const app = new Vue({
  el: '#pcoded',
});
