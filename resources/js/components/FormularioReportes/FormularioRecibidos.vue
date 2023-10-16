<template>
    <div>
        <div class="card">
            <div class="card-header bg-primary text-center">
                <h4 class="m-0 p-0 text-white">
                    <i class="far fa-file-signature fa-lg mr-2"></i>
                    Documentos Recibidos
                </h4>
            </div>
            <form action="/reporte/recibidos" method="POST" autocomplete="off">
                <input type="hidden" name="_token" :value="csrf">
                <input type="hidden" name="tipoDocumento" :value="tipoDocumentoSelected" >
                <div class="card-block">
                    <div class="form-row">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="nroDocumentoTipo">DESDE</label>
                            <div class="input-group">
                                <input type="date" name="desdeFecha"  required="required" class="form-control">
                                <input type="time" name="desdeHora" required="required"  class="form-control" style="max-width: 120px">
                            </div>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="nroDocumentoTipo">HASTA</label>
                            <div class="input-group">
                                <input type="date" name="hastaFecha"  required="required" class="form-control">
                                <input type="time" name="hastaHora"  required="required" class="form-control" style="max-width: 120px">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="nroDocumentoTipo" class="text-uppercase">Mostrar solo documentos recibidos por el usuario:</label>
                            <select v-model="usuario" name="usuario" class="form-control text-uppercase" >
                                <option :value="null">Todos</option>
                                <option v-for="user in listUsersArea" :value="user.id">{{ user.username }}</option>
                            </select>
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
            tipoDocumento:null,
            tipoDocumentoSelected:0,
            usuario:null,

            listDocumentos:[], // lista de todas las area
            listUsersArea:[], // lista de todas las area
        };
    },
    created(){
        this.getListDocumentos()
        this.getListAllUserArea()
    },
    mounted(){
        
    },
    filters:{

    },
    watch:{
        tipoDocumento(n,o){
            this.tipoDocumentoSelected = this.tipoDocumento.id
        }

    },
    computed:{

    },
    methods:{
        async getListAllUserArea() {
            const data  = await UserService.listForArea()
            this.listUsersArea = await data
        },

        async getListDocumentos() {
            const { data } = await GenericTablesService.listAll('tipo_documentos')
            this.listDocumentos = data
        },
        
    }
};

</script>