require('./bootstrap');

import Vue from 'vue';

import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
// 
window.Vue = require('vue').default;

Vue.component('v-select', vSelect)


Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('SfLoader', require('./Helpers/Loader.vue').default);
Vue.component('SfBusquedaPersonalizada', require('./components/BusquedaPersonalizada/BusquedaPersonalizada.vue').default);

Vue.component('SfQrGenerator', require('./components/QrGenerator/QrGenerator.vue').default);
Vue.component('SfUsuarios', require('./components/Usuarios/Usuarios.vue').default);

Vue.component('SfDerivar', require('./components/Derivar/Derivar.vue').default);
Vue.component('SfArchivar', require('./components/Archivar/Archivar.vue').default);
Vue.component('SfPorRecibir', require('./components/PorRecibir/PorRecibir.vue').default);
Vue.component('SfArchivados', require('./components/Archivados/Archivados.vue').default);

Vue.component('SfTipoDocumento', require('./components/TipoDocumento/TipoDocumento.vue').default);
Vue.component('SfDependencia', require('./components/Dependencia/Dependencia.vue').default);
Vue.component('SfArchivador', require('./components/Archivador/Archivador.vue').default);
Vue.component('SfNuevoTramite', require('./components/Tramite/NuevoTramite.vue').default);
Vue.component('SfEnProceso', require('./components/EnProceso/EnProceso.vue').default);
Vue.component('SfDerivados', require('./components/Derivados/Derivados.vue').default);


Vue.component('SfFormularioDerivados', require('./components/FormularioReportes/FormularioDerivados.vue').default);
Vue.component('SfFormularioPorRecibir', require('./components/FormularioReportes/FormularioPorRecibir.vue').default);
Vue.component('SfFormularioGenerados', require('./components/FormularioReportes/FormularioGenerados.vue').default);
Vue.component('SfFormularioRecibidos', require('./components/FormularioReportes/FormularioRecibidos.vue').default);
Vue.component('SfFormularioArchivados', require('./components/FormularioReportes/FormularioArchivados.vue').default);




var moment = require('moment');
moment.locale('es');

Vue.filter('fechaNormal',function(value){
  return moment(value).format('L');
})

import auth from './mixins/auth'

Vue.mixin(auth)

const app = new Vue({
    el: '#pcoded',
});
