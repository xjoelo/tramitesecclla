<template>
    <div>
        <sf-loader v-if="procesando"></sf-loader>

        <div class="card">
            <div class="card-header bg-primary text-center ">
                <h4 class="mb-0 text-white">MESA DE PARTES VIRTUAL</h4>
            </div>
            <div class="modal fade" id="modalAdvertencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div> -->
                        <div class="modal-body">
                            <div class="col-12 text-center">
                                <i class="fal fa-info-circle fa-4x text-info"></i>
                            </div>
                            <div class="col-12 text-center mt-2">
                                <h3 class="text-primary">MESA DE PARTES VIRTUAL</h3>
                                <h5>Deberá tener en cuenta que</h5>
                            </div>
                            <hr>
                            <div class="col-12 f-12 mt-3">
                                <ul class="basic-list list-icons">
                                    <li>
                                        <i class="far fa-calendar-alt text-primary p-absolute text-center d-block f-30"></i>
                                        <h6 class="f-13">Atención 24/7</h6>
                                        <p class=" f-12">La Mesa de Partes Virtual permite el registro de documentos las 24 horas del día los 7 días de la semana.</p>
                                    </li>
                                    <li>
                                        <h6 class="f-13">Horarios</h6>
                                        <i class="far fa-clock text-primary p-absolute text-center d-block f-30"></i>
                                        <p class=" f-12">La recepción de los documentos se realiza de lunes a viernes de <strong>8:00 AM a 05:00 PM</strong> Los documentos registrados fuera del horario se recepcionarán el siguiente día hábil.</p>
                                    </li>
                                    <li>
                                        <h6 class="f-13">Archivo Virtual</h6>
                                        <i class="far fa-file-pdf text-primary p-absolute text-center d-block f-30"></i>
                                        <p class=" f-12">Recuerda que los archivos virtuales deben estar en formato <strong>PDF</strong> y debe tener un un peso maximo de <strong>2 MB</strong> y un maximo de <strong>10 páginas</strong> si supera las cantidades, acercarse a Mesa de Partes peronalmente, de lo contrario su tramite no será aceptado</p>
                                    </li>
                                    <!-- <li>
                                        <h6 class="f-13">Importante</h6>
                                        <i class="far fa-exclamation-triangle text-primary p-absolute text-center d-block f-30"></i>
                                        <p class=" f-12">Recuerda que los trámites comerciales como <strong>SOLICITUD DE CONVENIO, FRACCIONAMIENTO, SOLICITUD RECLAMOS, SOLICITUD DE PROBLEMAS, AFILIACIÓN DE RECIBO DIGITAL Y ESTADOS DE CUENTA</strong> deberán ser ingresados por la <strong>OFICINA VIRTUAL COMERCIAL</strong> ya que no serán atendidos por este medio.</p>
                                    </li> -->
                                </ul>
                            </div>
                            <div class="col-12">
                                <a href="/consultar/documento" class="btn btn-dark btn-block">
                                    <i class="fas fa-file-search mr-2"></i>
                                    CONSULTAR TRÁMITE
                                </a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary " data-dismiss="modal">
                                Continuar <i class="fal fa-arrow-circle-right ml-2 fa-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary">DATOS DE REMITENTE</h5>
                            <hr class="my-2 bg-primary">
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="tipoPersona">TIPO PERSONA</label>
                            <select class="form-control" id="tipoPersona" v-model="tipoPersona">
                                <option :value="1">PERSONA NATURAL</option>
                                <option :value="2">PERSONA JÚRIDICA</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label for="tipoDocumentoPersona">TIPO DOCUMENTO</label>
                            <select :class="{
                                'form-control': true,
                                'disabled-select': tipoPersona == 2
                                }" id="tipoDocumentoPersona"
                                v-model="tipoDocumentoPersona"
                                >
                                <template v-if="tipoPersona == 1">
                                    <option value="dni">DNI</option>
                                    <option value="carnet">CARNET EXT.</option>
                                    <option value="pasaporte">PASAPORTE</option>
                                    <option value="otro">OTRO</option>
                                </template>
                                <template v-else>
                                    <option value="ruc">RUC</option>
                                </template>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-4">
                            <label for="nroDocumentoPersona">
                            NRO {{ tipoPersona == 1 ? 'DOCUMENTO' : 'RUC' }}
                            </label>
                            <input
                                v-model="nroDocumentoPersona"
                                type="number"
                                class="form-control"
                                id="nroDocumentoPersona"
                                placeholder="Ejem: 00000000"
                                />
                            <span class="messages popover-valid">
                            <i class="text-danger error icofont icofont-close-circled" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="" data-original-title="Email can't be blank"></i>
                            </span>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="fullName">
                            {{ tipoPersona == 1 ? 'NOMRBES Y APELLIDOS' : 'RAZÓN SOCIAL' }}
                            </label>
                            <input
                                v-model="fullName"
                                type="text"
                                class="form-control"
                                id="fullName"
                                :placeholder="tipoPersona == 1 ? 'JUAN PEREZ PEREZ' : 'MI EMPRESA S.A.C.'"
                                />
                        </div>
                        <template v-if="tipoPersona != 1">
                            <div class="form-group col-sm-12 col-md-7">
                                <label for="firma">
                                ¿QUIÉN FIRMA?
                                </label>
                                <input
                                    v-model="firma"
                                    type="text"
                                    class="form-control"
                                    id="firma"
                                    placeholder="Ejem: JUAN PEREZ PEREZ"
                                    />
                            </div>
                            <div class="form-group col-sm-12 col-md-5">
                                <label for="cargoFirma">
                                CARGO
                                </label>
                                <input
                                    v-model="cargoFirma"
                                    type="text"
                                    class="form-control"
                                    id="cargoFirma"
                                    placeholder="Ejem: Gerente..."
                                    />
                            </div>
                        </template>
                    </div>
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary">DATOS DEL DOCUMENTO</h5>
                            <hr class="my-2 bg-primary">
                        </div>
                        <div class="form-group col-sm-12 col-md-3">
                            <label for="idTipoDocumento">TIPO DE DOCUMENTO</label>
                            <select class="form-control" id="idTipoDocumento" v-model="idTipoDocumento">
                                <option v-for="(item, index) in listTypeDocuments" :value="item.id" :key="index">
                                    {{item.nombre}}
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-2">
                            <label for="nroDocumentoTipo">NRO DOCUMENTO</label>
                            <input type="text" class="form-control" id="nroDocumentoTipo" v-model="nroDocumentoTipo" placeholder="Ejem: 00000">
                        </div>
                        <div class="form-group col-sm-12 col-md-7">
                            <label for="siglas">SIGLAS</label>
                            <input type="text" class="form-control" id="siglas" v-model="siglas" placeholder="Ejem: SIGL-AS">
                        </div>
                         <div class="form-group col-sm-12 col-md-12">
                            <label for="asunto">ASUNTO</label>
                            <textarea class="form-control" id="asunto" v-model="asunto" placeholder="Ingrese asunto del documento"></textarea>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="folios">NRO FOLIOS</label>
                            <input type="number" class="form-control" id="folios" v-model="folios" placeholder="Ejem: 4" min="1">
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="fechaDocumento">FECHA DE DOCUMENTO</label>
                            <input type="date" class="form-control" id="fechaDocumento" v-model="fechaDocumento" placeholder="Ejem: 4">
                        </div>   
                        <div class="form-group col-sm-12 col-md-12">
                            <label for="adjuntos">
                                ELEMENTOS ADJUNTOS
                                <i class="fas fa-compact-disc ml-2"></i>
                                <i class="fas fa-folder-open ml-2"></i>
                            </label>
                            <textarea class="form-control" id="adjuntos" v-model="adjuntos" placeholder="Ingrese Archivadores, CDs, u otros archivos adjuntos"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                             <div class="btn-container">
                                <!--the three icons: default, ok file (img), error file (not an img)-->
                                    <h1 class="imgupload"><i class="fal fa-file-pdf"></i></h1>
                                    <h1 class="imgupload ok"><i class="fal fa-check-circle"></i></h1>
                                    <h1 class="imgupload stop"><i class="fal fa-times-circle"></i></h1>
                                <!--this field changes dinamically displaying the filename we are trying to upload-->
                                    <p id="namefile">¡Solo se permiten <strong>ARCHIVOS PDF</strong>!</p>
                                <!--our custom btn which which stays under the actual one-->
                                    <button type="button" id="btnup" class="btn btn-primary">Seleccione documento PDF</button>
                                <!--this is the actual file input, is set with opacity=0 beacause we wanna see our custom one-->
                                    <input type="file" value="" accept="application/pdf"  name="fileup" id="fileup">
                                </div>
                        </div>

                    </div>
                     
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-primary">INFORMACIÓN DE CONTACTO</h5>
                            <hr class="my-2 bg-primary">
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="emailOrigen">CORREO ELECTRÓNICO</label>
                            <input type="email" id="emailOrigen" class="form-control" placeholder="Ejem: ejemplo@gmail.com" v-model="emailOrigen">
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="celularOrigen">NRO CELULAR / TELÉFONICO</label>
                            <input type="tel" id="celularOrigen" class="form-control" placeholder="Ejem: 000000000" v-model="celularOrigen">
                        </div>
                        <div class="form-group col-sm-12 ">
                            <label for="direccionOrigen">DIRECCIÓN </label>
                            <input type="text" id="direccionOrigen" class="form-control" placeholder="Ejem: Psj. ejemplo #0000" v-model="direccionOrigen">
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" @click="sendForm"><i class="fal fa-paper-plane"></i> ENVIAR TRÁMITE</button>
            </div>
        </div>
    </div>
</template>
<script src="@2/components/Tramite/Tramite.js"></script>
<style scoped>
  #fechaDocumento {
    height: 38.48px;
  }
</style>
