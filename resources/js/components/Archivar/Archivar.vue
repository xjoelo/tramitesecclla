<template>
    <div>
        <SfLoader v-if="procesando"></SfLoader>
        <div class="modal fade" id="modalArchivarDocumentos" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-500" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-inbox-in mr-2"></i>
                            Archivar / Finalizar
                        </h5>
                    </div>
                    <div class="modal-body scrollable" id="scrollStyle" v-if="operacion">
                        <div class="form-row">
                            <div class="col-12 text-center">
                                <h4 class="format-numero">{{ operacion.documento.full_nro_registro }}</h4>
                                <h5 class="format-numero">{{ operacion.documento.full_documento }}</h5>
                                <hr>
                            </div>
                            <div class="col-12  form-group">
                                <label for="presentacionDocumento">Descripción</label>
                                <textarea v-model="descripcionArchivo" class="form-control"></textarea>
                            </div>
                            <div class="col-12  form-group">
                                <label for="presentacionDocumento">Archivador</label>
                                <select class="form-control text-uppercase" v-model="archivador">
                                    <option :value="null">..Seleccione Archivador</option>
                                    <option v-for="item in listArchivadores" :value="item.id">{{ item.nombre }} {{ item.periodo }} - <strong class="text-uppercase">{{ item.isPersonal ? item.user.username : 'OFICINA'}}</strong></option>
                                </select>
                                
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button  class="btn btn-sm btn-outline-danger" data-dismiss="modal" type="button" >
                            <i class="fal fa-times-circle mr-2"></i>
                            Cancelar
                        </button>
                        <button  class="btn btn-sm btn-primary" @click="archivar()" v-if="descripcionArchivo && archivador" >
                            <i class="far fa-inbox-in mr-2"></i>
                            Archivar Documento
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>     
</template>
<script src="@/components/Archivar/Archivar.js"></script>