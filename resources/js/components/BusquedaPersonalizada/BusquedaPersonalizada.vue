<template>
    <div>
        <form action="/buscar/personalizada" method="POST">
            <input type="hidden" name="_token" :value="csrf">
            <input type="hidden" name="dependencia" :value="dependenciaSelected" >
            <div class="row">
                <div class="form-group col-sm-12 col-md-12 col-lg-4">
                    <label for="nroDocumentoTipo">ORÍGEN</label>
                    <select name="origenDocumento" class="form-control" v-model="origenDocumento">
                        <option value="0">INTERNO</option>
                        <option value="1">EXTERNO</option>
                    </select>
                </div>
                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="nroDocumentoTipo">DESDE</label>
                    <input type="date" name="desde" class="form-control" v-model="desde">
                </div>
                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="nroDocumentoTipo">HASTA</label>
                    <input type="date" name="hasta" class="form-control" v-model="hasta">
                </div>
                <div class="form-group col-12">
                    <label for="nroDocumentoTipo">UNIDAD ORGANICA</label>
                    <v-select class="form-control form-control-especial" label="nombre" v-model="dependencia" :options="listDependencias" v-if="origenDocumento == 0">
                        <template #no-options="{ search, searching, loading }">
                            No se encontraron resultados para "<strong>{{ search }}</strong>"
                        </template>
                    </v-select>
                    <input v-else type="text" name="dependencia" class="form-control">
                </div>
                <div class="form-group col-sm-5">
                    <label for="nroDocumentoTipo">RUC/DNI</label>
                    <input name="rucdni" class="form-control" type="text" v-model="rucdni">
                </div>
               <div class="form-group col-sm-7">
                    <label for="nroDocumentoTipo">FIRMA</label>
                    <input name="firma" class="form-control" type="text" v-model="firma">
                </div>
                
                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="nroDocumentoTipo">TIPO DE DOCUMENTO</label>
                    <select name="tipoDocumento" v-model="tipoDocumento" class="form-control">
                        <option :value="null">.. Seleccione ..</option>
                        <option v-for="item in listDocumentos" :value="item.id">{{ item.nombre }}</option>
                    </select>
                </div>
                <div class="form-group col-sm-12 col-md-6 col-lg-2">
                    <label for="nroDocumentoTipo">N° DOCUMENTO</label>
                    <input name="nroDocumento" type="text" class="form-control" v-model="nroDocumentoTipo">
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="nroDocumentoTipo">SIGLAS</label>
                    <input name="nroDocumento" type="text" class="form-control" v-model="siglas">
                </div>
                <div class="form-group col-sm-12">
                    <label for="nroDocumentoTipo">ASUNTO</label>
                    <textarea name="asunto" class="form-control" v-model="asunto"></textarea>
                </div>
                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                    <label for="nroDocumentoTipo">&nbsp;</label>
                    <button type="submit" class="btn btn-block btn-primary" style="padding: 6.75px">
                        <i class="fa fa-search mr-2"></i> Buscar
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script src="@/components/BusquedaPersonalizada/BusquedaPersonalizada.js"></script>