<template>
    <div>
        <SfLoader v-if="isLoadend"></SfLoader>
        <SfDerivar :user="user" :nuevo='true' ref="derivarComponent" @derivado='isDerivado' ></SfDerivar>

        <div class="card">
            <div class="card-header">
                <h5 class="user-select-none mb-0">
                    <i class="fad fa-file-plus mr-2 fa-lg"></i> REGISTRO TRÁMITE
                </h5>
            </div>
            <div class="card-body">
                <div class="col-md-12" v-if="documentoAdjuntar">
                    <div class="card bg-c-blue order-card">
                        <div class="card-block text-white">
                            <h6>Documento de Referencia</h6>
                            <h2 class="format-numero">{{ documentoAdjuntar.full_nro_registro }}</h2>
                            <p class="m-b-0 format-numero">{{ documentoAdjuntar.full_documento }}</p>
                            <i class="card-icon far fa-file-alt "></i>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row d-flex justify-content-md-center" v-if="!hideOrigenDocumento">
                        <div class="col-12 col-md-4">
                             <fieldset >
                            <legend>ORIGEN DEL DOCUMENTO</legend>
                            <select class="form-control" id="tipoDocumento" v-model="origenDocumento">
                                <option :value="0">Documento interno</option>
                                <option :value="1">Documento externo</option>
                            </select>
                        </fieldset>
                        </div>
                       
                    </div>
                    <div class="row mb-3 mt-3">
                        <div class="col-12">
                            <h5 class="text-primary">
                                <i class="fas fa-clipboard-check mr-2"></i>
                                DATOS DE REGISTRO
                            </h5>
                            <hr class="my-2 bg-primary">
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="nroDocumentoTipo">FECHA DE REGISTRO</label>
                            <input type="date" class="form-control" id="fechaRegistro"  readonly>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="siglasInterno">
                                <i class="far fa-exclamation-triangle text-danger mr-2"></i>
                                URGENCIA
                            </label>
                            <select class="form-control" id="issueDocumentAs" v-model="urgencia" >
                                <option value="1">NORMAL</option>
                                <option value="2">URGENTE</option>
                                <!-- <option value="area">MUY URGENTE</option> -->
                            </select>
                        </div>
                        
                    </div>
                    <div class="row mb-3" v-if="origenDocumento == 0">
                        <div class="col-12">
                            <h5 class="text-primary">
                                <i class="fas fa-cog mr-2"></i>
                                DATOS DE ORIGEN
                            </h5>
                            <hr class="my-2 bg-primary">
                        </div>
                        <div class="form-group col-sm-12 col-md-3">
                            <label for="nroDocumentoTipo">Origen</label>
                            <input type="text" class="form-control" :value="origenDocumento == 0 ? 'DOCUMENTO INTERNO':'DOCUMENTO EXTERNO' " readonly>
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label for="issueDocumentAs">EMITIR COMO</label>
                            <select class="form-control" id="issueDocumentAs" v-model="issueDocumentAs" @change="generateSiglas">
                                <option value="personal">DOCUMENTO PERSONAL</option>
                                <option value="area">DOCUMENTO ÁREA</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="siglasInterno">
                                OFICINA
                            </label>
                            <input type="text" class="form-control" :value="user.dependencia.nombre" readonly>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="siglasInterno">
                                FIRMA
                            </label>
                            <input type="text" class="form-control" :value="issueDocumentAs == 'personal' ? user.full_name : user.dependencia.representante" readonly>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="siglasInterno">
                                CARGO
                            </label>
                            <input type="text" class="form-control" :value="issueDocumentAs == 'personal' ? user.cargo : user.dependencia.cargo" readonly>
                        </div>
                        
                        
                    </div>
                    
                    <template v-if="!origenDocumento">
                        <div class="row mb-3">
                            <div class="col-12">
                                
                                <h5 class="text-primary">
                                    <i class="fas fa-file-signature mr-2"></i>
                                    DATOS DEL DOCUMENTO
                                </h5>
                                <hr class="my-2 bg-primary">
                            </div>
                            
                            <div class="form-group col-sm-12 col-md-3">
                                <label for="idTipoDocumento">TIPO DE DOCUMENTO</label>
                                <select class="form-control" id="idTipoDocumento" v-model="idTipoDocumentoInterno" @change="getNumeroTipoDocumento">
                                    <option value="">Seleccione..</option>
                                    <option v-for="(item, index) in listTypeDocuments" :value="item.id" :key="index">
                                        {{item.nombre}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12 col-md-2">
                                <label for="nroDocumentoTipo">NRO DOCUMENTO</label>
                                <input type="text" class="form-control" id="nroDocumentoTipo" v-model="nroDocumentoTipoInterno" :readonly='!isNewNumero'>
                            </div>
                            <div class="form-group col-sm-12 col-md-7">
                                <label for="siglasInterno">SIGLAS</label>
                                <input type="text" class="form-control" id="siglasInterno" v-model="siglasInterno" readonly>
                            </div>
                            <div class="form-group col-sm-12 col-md-12">
                                <label for="asunto">ASUNTO</label>
                                <textarea class="form-control" id="asunto" v-model="asuntoInterno" placeholder="Ejem: Este es un ejemplo de descripción..."></textarea>
                            </div>

                            <div class="form-group col-sm-12 col-md-6">
                                <label for="folios">NRO FOLIOS</label>
                                <input type="number" class="form-control" id="folios" v-model="foliosInterno" placeholder="Ejem: 4" min="1">
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label for="fechaDocumento">FECHA DE DOCUMENTO</label>
                                <input type="date" class="form-control" id="fechaDocumento" v-model="fechaDocumentoInterno" placeholder="Ejem: 4">
                            </div>
                            <div class="form-group col-sm-12 col-md-12">
                                <label for="adjuntos">
                                    ELEMENTOS ADJUNTOS
                                    <i class="fas fa-compact-disc ml-2"></i>
                                    <i class="fas fa-folder-open ml-2"></i>
                                </label>
                                <textarea class="form-control" id="adjuntos" v-model="adjuntos" placeholder="Ingrese Archivadores, CDs, u otros archivos adjuntos"></textarea>
                            </div>
                            <!-- <div class="form-group col-sm-12 col-md-3">
                                <label>ADJUNTAR ARCHIVO (PDF)</label>
                                <input type="file" accept="application/pdf" id="archivoInterno" class="form-control" style="padding: 3px 9px;">
                            </div> -->
                        </div>
                    </template>
                    <template v-else>
                        <div class="col-12">
                            <div class="row mb-3">
                                <div class="col-12">

                                    <h5 class="text-primary">
                                        <i class="fas fa-user-tie mr-2"></i>
                                        DATOS DE REMITENTE
                                    </h5>
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
                                    NRO {{ tipoPersona == 1 ? 'DNI' : 'RUC' }}
                                    </label>
                                    <div class="input-group">
                                        <input
                                        @keyup.enter="buscarApi()"
                                        v-model="nroDocumentoPersona"
                                        type="number"
                                        class="form-control"
                                        :class="{'is-invalid':errores.hasOwnProperty('nroDocumentoPersona')}"
                                        id="nroDocumentoPersona"
                                        placeholder="Ejem: 00000000"
                                        />
                                        <template v-if="tipoDocumentoPersona == 'dni' || tipoDocumentoPersona=='ruc'">
                                            <div class="input-group-append">
                                                <button class="btn btn-sm btn-primary" @click="buscarApi()">
                                                    <i class="fas fa-search mr-0"></i>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                    <small v-if="errores.hasOwnProperty('nroDocumentoPersona')" class="text-danger">{{ errores.nroDocumentoPersona[0] }}</small>
                                    
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="fullName">
                                    {{ tipoPersona == 1 ? 'NOMRBES Y APELLIDOS' : 'RAZÓN SOCIAL' }}
                                    </label>
                                    <input
                                        v-model="fullName"
                                        type="text"
                                        class="form-control"
                                        :class="{'is-invalid':errores.hasOwnProperty('dependencia')}"
                                        id="fullName"
                                        placeholder="Ejem: Juan..."
                                        />
                                    <small v-if="errores.hasOwnProperty('dependencia')" class="text-danger">{{ errores.dependencia[0] }}</small>
                                </div>
                                <template v-if="tipoPersona != 1">
                                    <div class="form-group col-sm-12 col-md-7">
                                        <label for="firma">
                                        ¿QUIÉN FIRMA?
                                        </label>
                                        <input
                                            v-model="firma"
                                            type="text"
                                            :class="{'is-invalid':errores.hasOwnProperty('firma')}"
                                            class="form-control"
                                            id="firma"
                                            placeholder="Ejem: JUAN PEREZ PEREZ"
                                            />
                                        <small v-if="errores.hasOwnProperty('firma')" class="text-danger">{{ errores.firma[0] }}</small>
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
                            <div class="row mb-3">
                                <div class="col-12 mb-2">
                                    <div class="col-12">
                                        <h5 class="text-primary">
                                            <i class="fas fa-file-pdf mr-2"></i>
                                            DATOS DEL DOCUMENTO
                                        </h5>
                                        <hr class="my-2 bg-primary">
                                    </div>
                                </div>
                                <div class="form-group col-sm-12 col-md-3">
                                    <label for="idTipoDocumento">TIPO DE DOCUMENTO</label>
                                    <select class="form-control" id="idTipoDocumento" :class="{'is-invalid':errores.hasOwnProperty('idTipoDocumento')}" v-model="idTipoDocumento">
                                        <option value="">Seleccione..</option>
                                        <option v-for="(item, index) in listTypeDocuments" :value="item.id" :key="index">
                                            {{item.nombre}}
                                        </option>
                                    </select>
                                    <small v-if="errores.hasOwnProperty('idTipoDocumento')" class="text-danger">{{ errores.idTipoDocumento[0] }}</small>
                                </div>
                                <div class="form-group col-sm-12 col-md-2">
                                    <label for="nroDocumentoTipo">NRO DOCUMENTO</label>
                                    <input type="text" class="form-control" id="nroDocumentoTipo" v-model="nroDocumentoTipo" placeholder="Ejem: 00000000">
                                </div>
                                <div class="form-group col-sm-12 col-md-7">
                                    <label for="siglas">SIGLAS</label>
                                    <input type="text" class="form-control" id="siglas" v-model="siglas" placeholder="Ejem: SIGL-AS">
                                </div>
                                <div class="form-group col-sm-12 col-md-12">
                                    <label for="asunto">ASUNTO</label>
                                    <textarea class="form-control" id="asunto" :class="{'is-invalid':errores.hasOwnProperty('asunto')}" v-model="asunto" placeholder="Ingrese Asunto del Documento"></textarea>
                                    <small v-if="errores.hasOwnProperty('asunto')" class="text-danger">{{ errores.asunto[0] }}</small>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="folios">NRO FOLIOS</label>
                                    <input type="number" :class="{'is-invalid':errores.hasOwnProperty('folios')}" class="form-control" id="folios" v-model="folios" placeholder="Ejem: 4" min="1">
                                    <small v-if="errores.hasOwnProperty('folios')" class="text-danger">{{ errores.folios[0] }}</small>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="fechaDocumento">FECHA DE DOCUMENTO</label>
                                    <input type="date" :class="{'is-invalid':errores.hasOwnProperty('fechaDocumento')}"  class="form-control" id="fechaDocumento" v-model="fechaDocumento" placeholder="Ejem: 4">
                                    <small v-if="errores.hasOwnProperty('fechaDocumento')" class="text-danger">{{ errores.fechaDocumento[0] }}</small>
                                </div>
                                <div class="form-group col-sm-12 col-md-12">
                                    <label for="adjuntos">
                                        ELEMENTOS ADJUNTOS
                                        <i class="fas fa-compact-disc ml-2"></i>
                                        <i class="fas fa-folder-open ml-2"></i>
                                    </label>
                                    <textarea class="form-control" id="adjuntos" :class="{'is-invalid':errores.hasOwnProperty('adjuntos')}" v-model="adjuntos" placeholder="Ingrese Archivadores, CDs, u otros archivos adjuntos"></textarea>
                                    <small v-if="errores.hasOwnProperty('adjuntos')" class="text-danger">{{ errores.adjuntos[0] }}</small>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <h5 class="text-primary">
                                        <i class="fas fa-address-book mr-2"></i>
                                        DATOS DE CONTACTO
                                    </h5>
                                    <hr class="my-2 bg-primary">
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="emailOrigen">CORREO ELECTRÓNICO</label>
                                    <input type="email" id="emailOrigen" class="form-control" :class="{'is-invalid':errores.hasOwnProperty('emailOrigen')}" placeholder="Ejem: ejemplo@gmail.com" v-model="emailOrigen">
                                    <small v-if="errores.hasOwnProperty('emailOrigen')" class="text-danger">{{ errores.emailOrigen[0] }}</small>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="celularOrigen">NRO CELULAR / TELÉFONICO</label>
                                    <input type="tel" id="celularOrigen"  :class="{'is-invalid':errores.hasOwnProperty('celularOrigen')}" class="form-control" placeholder="Ejem: 000000000" v-model="celularOrigen">
                                    <small v-if="errores.hasOwnProperty('celularOrigen')" class="text-danger">{{ errores.celularOrigen[0] }}</small>
                                </div>
                                <div class="form-group col-sm-12 col-md-12">
                                    <label for="direccionOrigen">DIRECCIÓN </label>
                                    <input type="text" id="direccionOrigen" class="form-control" placeholder="Ejem: Psj. ejemplo #0000" v-model="direccionOrigen">
                                </div>
                            </div>
                        </div>
                    </template>
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
                                <input type="file" value="" accept="application/pdf" name="fileup" id="fileup">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <button v-if="origenDocumento == 0" class="btn btn-primary" @click="sendFormInternal">
                                <i class="fal fa-save mr-2"></i>
                                Guardar
                            </button>
                            <button v-else class="btn btn-primary" @click="sendFormExternal">
                                <i class="fal fa-save mr-2"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>
<script src="@/components/Tramite/NuevoTramite.js"></script>
<style scoped>
    #fechaDocumento {
        height: 38.48px;
    }
    .column-delete {
        text-align: center;
        max-inline-size: 65px;
        min-inline-size: 65px;
        inline-size: 65px;
    }

    .table.table-xs tbody td, .table.table-xs tbody th {
        padding: 0px 5px !important ;
    }
    .btn-sm {
        padding: 10px 14px !important;
        line-height: 16px;
        font-size: 11px;
    }
   .form-control.is-invalid {
        border-color: #FF0018;
        box-shadow: 0px 0px 3px #FF0000;
    }
    .order-card .card-icon {
        position: absolute;
        right: 10px;
        font-size: 80px;
        top:15px;
        opacity: 0.5;
    }
</style>
