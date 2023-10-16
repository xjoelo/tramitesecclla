<template>
    <div>
        <div class="card">
            <div class="card-header bg-primary text-center">
                <h4 class="m-0 p-0 text-white">
                    <i class="fas fa-share-square fa-flip-vertical fa-lg mr-2"></i>
                    Documentos Derivados
                </h4>
            </div>
            <form action="/reporte/derivados" method="POST" autocomplete="off">
                <input type="hidden" name="_token" :value="csrf">
                <input type="hidden" name="dependencia" :value="dependenciaSelected" >
                <input type="hidden" name="tipoDocumento" :value="tipoDocumentoSelected" >
                <div class="card-block">
                    <div class="form-row">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="nroDocumentoTipo">DESDE</label>
                            <div class="input-group">
                                <input type="date" name="desdeFecha"  id="desdeFecha" required="required" class="form-control">
                                <input type="time" name="desdeHora" id="desdeHora" required="required"  class="form-control" style="max-width: 120px">
                            </div>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="nroDocumentoTipo">HASTA</label>
                            <div class="input-group">
                                <input type="date" name="hastaFecha" id="hastaFecha"  required="required" class="form-control">
                                <input type="time" name="hastaHora" id="hastaHora" class="form-control" style="max-width: 120px">
                            </div>
                        </div>
                        <div class="form-group col-sm-12 ">
                            <hr class="m-0 p-0">
                            <div class="form-row align-content-center pt-2">
                                <div class="col-8 text-uppercase">
                                    <label for="mostrarRecibidos" style="font-size: 12px"  class="m-0 p-0">Mostrar los documentos que ya fueron recibidos:</label>
                                </div>
                                <div class="col-4">
                                    <label class="--switch m-0 p-0">
                                        <input type="checkbox" value="1" id="mostrarRecibidos" name="showRecibidos">
                                        <span class="--slider">
                                            <i class="fas fa-check"></i>
                                            <i class="fas fa-times"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <hr class="m-0 p-0">            
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="nroDocumentoTipo" class="text-uppercase">Mostrar solo documentos enviados a la Oficina:</label>
                            <v-select class="form-control form-control-especial" 
                                label="nombre"
                                v-model="dependencia"
                                :options="listDependencias" 
                                placeholder="TODOS .. o seleccione una oficina">
                                <template #no-options="{ search, searching, loading }">
                                    No se encontraron resultados para "<strong>{{ search }}</strong>"
                                </template>
                            </v-select>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="nroDocumentoTipo">TIPO DE DOCUMENTO</label>
                            <v-select class="form-control form-control-especial" 
                                label="nombre"
                                v-model="tipoDocumento"
                                :options="listDocumentos" 
                                placeholder="TODOS .. o seleccione un tipo de documento">
                                <template #no-options="{ search, searching, loading }">
                                    No se encontraron resultados para "<strong>{{ search }}</strong>"
                                </template>
                            </v-select>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">
                        GENERAR REPORTE
                        <i class="fas fa-arrow-alt-circle-right ml-2 fa-lg"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import UserService from '@/services/UserService'
import GenericTablesService from '@/services/GenericTablesService'

var moment = require('moment');
moment.locale('es');



export default {
    name: 'SfBusquedaPersonalizada',
    components:{
             
    },
    props: ['user','nuevo'],
    data(){
        return {
            dependencia:null,
            dependenciaSelected:0,
            tipoDocumento:null,
            tipoDocumentoSelected:0,

            listDependencias:[], // lista de todas las area
            listDocumentos:[], // lista de todas las area
        };
    },
    created(){
        this.getListDependencias()
        this.getListDocumentos()
        
    },
    mounted(){
        this.getDate()
    },
    filters:{

    },
    watch:{
        dependencia(n,o){
            this.dependenciaSelected = this.dependencia.id
        },
        tipoDocumento(n,o){
            this.tipoDocumentoSelected = this.tipoDocumento.id
        }

    },
    computed:{

    },
    methods:{
        getDate(){
            var today = moment().format("YYYY-MM-DD")
            document.getElementById("desdeFecha").value = today
            document.getElementById("desdeHora").value = "08:00"
            // document.getElementById("hastaHora").value = "17:00:00"
            document.getElementById("hastaFecha").value = today
            this.desdeFecha = today
            this.hastaFecha = today
            this.desdeHora = "08:00"
        },
        async getListDependencias() {
            const { data } = await GenericTablesService.listAll('dependencias')
            this.listDependencias = data
        },
        async getListDocumentos() {
            const { data } = await GenericTablesService.listAll('tipo_documentos')
            this.listDocumentos = data
        },
        
    }
};

</script>