<template>
    <div>
        <SfLoader v-if="procesando"></SfLoader>
        <div class="modal fade" id="modalDerivarDocumentos" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content mb-3 text-center" v-if="nuevo">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col text-center mb-2">
                                <i class="far fa-check-circle text-success fa-3x"></i>
                            </div>
                        </div>
                        <div class="bar bg-primary text-white text-center py-1">
                            <strong>EL DOCUMENTO SE REGISTRO CON EXITO</strong>
                        </div>
                        <div class="row mb-2 " v-if="operacion">
                            <div class="col-12 f-20">
                                <span >NRO. DE REGISTRO : <strong class="f-w-900 format-numero" >{{ operacion.documento.full_nro_registro }}</strong></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="/documento/proceso" class="btn btn-primary btn-sm">
                                    <i class="fas fa-cog mr-1 fa-spin"></i>
                                    Explorar Documentos en proceso
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fal fa-share-square mr-2"></i>
                            DERIVAR 
                        </h5>
                    </div>
                    <div class="modal-body scrollable" id="scrollStyle" v-if="operacion">
                        <div class="form-row">
                            <div class="col-12 text-center">
                                <h4 class="format-numero">{{ operacion.documento.full_nro_registro }}</h4>
                                <h5 class="format-numero">{{ operacion.documento.full_documento }}</h5>
                                <hr>
                            </div>
                            <div class="col-sm-12 col-md-9 form-group">
                                <label for="area-a-derivar">Área a derivar</label>
                                <v-select class="form-control form-control-especial" label="nombre"    v-model="areaDerivar" :options="listDependencias">
                                    <template #no-options="{ search, searching, loading }">
                                        No se encontraron resultados para "<strong>{{ search }}</strong>"
                                    </template>
                                </v-select>
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label for="presentacionDocumento">Usuario</label>
                                <select id="presentacionDocumento" class="form-control"  v-model="usuarioDerivar" :disabled="user.dependencia.id != areaDerivar.id">
                                    <option :value="null">Selecciona...</option>
                                    <option :value="user" v-for="user in listUsersArea" >{{user.username}}</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-9  form-group">
                                <label for="presentacionDocumento">Proveido de Atención</label>
                                <textarea v-model="proveidoAtencion" class="form-control"></textarea>
                            </div>
                            <div class="col-sm-12 col-md-3 form-group">
                                <label for="presentacionDocumento">Presentación</label>
                                <div class="input-group">
                                    <select id="presentacionDocumento" class="form-control" v-model="presentacionDocumento">
                                        <option :value="1">Original</option>
                                        <option :value="2">Copia</option>
                                        <option :value="3">Digital</option>
                                        
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-sm btn-primary btn-block" style="padding-block: 10px;" @click="addAreaDerivar">
                                            <i class="far fa-plus mr-0"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" v-if="!listAreasDerivar.length">
                                <div class="text-center py-3">
                                    <small class="text-muted"><i class="far fa-ban text-muted mr-2"></i>No se agregaron oficinas destinatarias</small>
                                </div>
                            </div>
                            <div class="col-sm-12" v-else>
                                    <!-- <h6 class=" text-center">Lista de áreas a derivar</h6> -->
                                    <div class="table-responsive">
                                        <table class="table table-xs table-styling table-bordered table-hover">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th class="column-delete py-1"><i class="fal fa-trash-alt text-white"></i></th>
                                                    <th class="py-1">Área</th>
                                                    <th class="py-1">Usuario</th>
                                                    <th class="py-1">Proveido de Atención</th>
                                                    <th  class="py-1"width="100px">Presentación</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in listAreasDerivar" :key="index">
                                                    <td class="column-delete">
                                                        <button type="button" @click="removeListAreasDerivar(index)" class="btn btn-mini text-danger btn-link">
                                                            <i class="fal fa-trash-alt mr-0"></i>
                                                        </button>
                                                    </td>
                                                    <td>{{ item.dependencia.nombre }}</td>
                                                    <td>
                                                        <template v-if="item.usuario">
                                                            {{ item.usuario.full_name }}
                                                        </template>
                                                        
                                                    </td>
                                                    <td>{{ item.proveidoAtencion }}</td>
                                                    <td>{{ item.presentacionDocumento == 1 ? 'Original' : (item.presentacionDocumento == 2 ? 'Copia': 'Digital') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <template v-if="nuevo">
                            <a href="/tramite"  class="btn btn-sm btn-outline-danger" >
                                <i class="fal fa-times-circle mr-2"></i>
                                Cancelar
                            </a>
                        </template>
                        <template v-else>
                            <button  class="btn btn-sm btn-outline-danger" data-dismiss="modal" type="button" >
                                <i class="fal fa-times-circle mr-2"></i>
                                Cancelar
                            </button>
                        </template>
                        <button  class="btn btn-sm btn-primary" @click="derivar()" v-if="listAreasDerivar.length">
                            <i class="fal fa-share-square mr-2"></i>
                            Derivar Documento
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
</template>
<script src="@/components/Derivar/Derivar.js"></script>

