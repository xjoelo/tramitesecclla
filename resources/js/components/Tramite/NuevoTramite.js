import GenericTableServices from "@2/services/GenericTablesService.js"
import TramiteService from "@/services/TramiteService.js"
import UserService from "@/services/UserService.js"
import axios from "axios"
var moment = require('moment');
moment.locale('es');

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
export default {
    name: 'SfNuevoTramite',
    props: [
        'nameEntity',
        'user',
        'documentoAdjuntar',
        'adjuntar',
        'operacionAdjuntar'
    ],
    data() {
        return {
            origenDocumento: 1,
            tipoPersona: 1,
            tipoDocumentoPersona: 'dni',
            nroDocumentoPersona: '',
            fullName: '',
            firma: '',
            cargoFirma: '',
            issueDocumentAs: 'personal',

            idTipoDocumentoInterno: '',
            nroDocumentoTipoInterno: '',
            foliosInterno: '',
            fechaDocumentoInterno: '',
            asuntoInterno: '',
            siglasInterno: '',
            adjuntos:null,
            idTipoDocumento: '',
            nroDocumentoTipo: '',
            siglas: '',
            folios: '',
            asunto: '',
            fechaDocumento: '',

            emailOrigen: '',
            celularOrigen: '',
            direccionOrigen: '',
            archivo: null,

            presentacionDocumento: 1,

            urgencia : 1,

            listTypeDocuments: [],

            currentNumeroTipoDocumento: {},

            isLoadend: false,
            listDependencias: [],
            dependenciasIndexed: [],

            areaDerivar: '',
            listAreasDerivar: [],

            keyVueSelect:1,
            hideOrigenDocumento : false,

            listUsersArea:[],
            proveidoAtencion:null,
            usuarioDerivar:null,
            documento:null,
            isNewNumero:false,
            errores:{},
        }
    },
    mounted() {
        this.getListAllTypeDocuments()
        // this.getListAllUserArea()
        this.getListDependencias()
        this.precargaDatos()
        this.generateSiglas()
        this.getDate()
    },
    computed: {
        listTypeDocumentsIndexed() {
            return this.listTypeDocuments.reduce((acc, item) => ({
                ...acc,
                [item.id]: item
            }), {})
        },

    },
    watch: {
        tipoPersona(newValue, oldValue) {
            if (newValue == 2) {
                this.tipoDocumentoPersona = 'ruc'
            } else {
                this.tipoDocumentoPersona = 'dni'
            }
        },
        areaDerivar(newValue,oldValue){
            if(this.areaDerivar){
                if(this.areaDerivar.id == this.user.dependencia.id){
                    if (this.listUsersArea.length <= 0 ) {
                        this.getListAllUserArea()
                    }
                }
            }
            
        }
    },
    methods: {
        returnError(value){
            return this.errores.hasOwnProperty(value)
        },
        accionDerivar(operacion){
            this.operacion = operacion
            this.$refs.derivarComponent.showDerivar(this.operacion);
        },
        getDate(){
            var today = moment().format("YYYY-MM-DD")
            document.getElementById("fechaRegistro").value = today
            this.fechaDocumento = today
        },
        precargaDatos(){
            if(this.user.isPublico == 0 || this.user.dependencia.isPublico == 0){
                this.hideOrigenDocumento = true
                this.origenDocumento = 0
                
            }
            this.issueDocumentAs ='area' 
        },

        async addAreaDerivar() {
            if(!this.areaDerivar) return
            // if(!this.dependenciasIndexed[this.areaDerivar.id]) return
            const currentDependencia = this.dependenciasIndexed[this.areaDerivar.id]
            // if(this.listAreasDerivar.find( ({ dependencia }) => dependencia.id == currentDependencia.id)) return
            await this.listAreasDerivar.push({
                usuario : this.usuarioDerivar,
                proveidoAtencion : this.proveidoAtencion,
                dependencia : this.dependenciasIndexed[this.areaDerivar.id],
                presentacionDocumento : this.presentacionDocumento
            })
            this.keyVueSelect = this.keyVueSelect +1
            this.usuarioDerivar = null
            // this.areaDerivar = null

        },
        removeListAreasDerivar(index) {
            this.listAreasDerivar.splice(index,1)
        },
        async getListDependencias() {
            try {
                const { data } = await GenericTableServices.listAll('dependencias')
                if(data.length) {
                    this.dependenciasIndexed = data.reduce((acc,item) => ({
                        ...acc,
                        [item.id]: item
                    }) ,{})
                }
                this.listDependencias = data

            } catch (error) {

            }
        },
        generateSiglas() {
            const currentYear = new Date().getFullYear()
            const siglasEntity = this.nameEntity
            const userSiglas = this.issueDocumentAs == 'personal' ? `/${this.user.iniciales}` : ''
            const areaSiglas = this.user.dependencia.siglas
            this.siglasInterno = `${currentYear}/${siglasEntity}/${areaSiglas}${userSiglas}`
            // this.generateNumeroDocumento()
            this.getNumeroTipoDocumento()
        },
        async getNumeroTipoDocumento(){
            if (!this.idTipoDocumentoInterno) return this.nroDocumentoTipoInterno = ''
            this.isLoadend = true
            try{
                let datos = {
                    'idTipoDocumento' : this.idTipoDocumentoInterno,
                    'isPersonal' : this.issueDocumentAs == 'personal' ? 1:0
                }
                const data = await TramiteService.selectNumeracionUserAuth(datos)
                const newNumeracion = data
                this.currentNumeroTipoDocumento = newNumeracion
                this.nroDocumentoTipoInterno = newNumeracion.numero

                if(newNumeracion.numero == 1 ){
                    this.isNewNumero = 1
                }
                else{
                    this.isNewNumero = false
                }
            }catch (error){
                Swal.fire({ icon: 'warning', title: 'Estera!', text: 'Algo salio mal, intentalo en unos minutos' })
            }
            this.isLoadend = false
        },

        async getListAllTypeDocuments() {
            try {
                const { data } = await GenericTableServices.listAll('tipo_documentos')
                this.listTypeDocuments = await data
            } catch (error) {

            }
        },

        async getListAllUserArea() {
            try {
                const data  = await UserService.listForArea()
                this.listUsersArea = await data
            } catch (error) {

            }
        },
        
        dataToBeSentInternal() {
            let formData = new FormData()
            formData.append('origenDocumento', this.origenDocumento)
            formData.append('idTipoDocumento', this.idTipoDocumentoInterno)
            formData.append('nroDocumentoTipo', this.nroDocumentoTipoInterno)
            formData.append('folios', this.foliosInterno)
            formData.append('fechaDocumento', this.fechaDocumentoInterno)
            formData.append('asunto', this.asuntoInterno)
            formData.append('adjuntos', this.adjuntos)
            formData.append('urgencia',this.urgencia)
            formData.append('siglas', this.siglasInterno)
            formData.append('emitirDocumento', this.issueDocumentAs)
            formData.append('numeracion_tipo_documentos', JSON.stringify(this.currentNumeroTipoDocumento))
            formData.append('isNewNumero',this.isNewNumero)
            if (document.getElementById('fileup').files[0]) {
                formData.append('archivo', document.getElementById('fileup').files[0])
            }
            if (this.documentoAdjuntar) {
                formData.append('documentoReferencia',JSON.stringify(this.documentoAdjuntar))
                formData.append('adjuntar',this.adjuntar)
                formData.append('operacionAdjuntar',this.operacionAdjuntar)
            }
            return formData;
        },
        async sendFormInternal() {
            this.isLoadend = true
            const params = this.dataToBeSentInternal()
            try {
                const {data} = await axios.post('/documento/insertInternal', params)
                this.isLoadend = false
                this.documento = data.documento
                this.accionDerivar(data,true)
                // $('#modalDerivarDocumentos').modal({
                //     keyboard: false,
                //     show: true,
                //     backdrop: 'static'
                // })
        
                console.log(data)
                // window.location.reload()
            } catch (error) {
                console.log(error.response.data.errors)
                $.toast({
                    heading: 'Corriga los errores',
                    text: error.response.data.errors,
                    icon: 'error',
                    position: 'top-right',
                    hideAfter: 10000
                })
                this.isLoadend = false
            }
        },
        dataToBeSentExternal() {
            let formData = new FormData();
            formData.append('tipoPersona', this.tipoPersona)
            formData.append('tipoDocumentoPersona', this.tipoDocumentoPersona)
            formData.append('nroDocumentoPersona', this.nroDocumentoPersona)
            if (this.tipoPersona == 1) {
                formData.append('firma', String(this.fullName).toUpperCase())
                formData.append('dependencia', String(this.fullName).toUpperCase())
            } else {
                formData.append('firma', String(this.firma).toUpperCase())
                formData.append('dependencia', String(this.fullName).toUpperCase())
                formData.append('cargoFirma', String(this.cargoFirma).toUpperCase())
            }
            formData.append('idTipoDocumento', this.idTipoDocumento)
            formData.append('nroDocumentoTipo', this.nroDocumentoTipo)
            formData.append('siglas', String(this.siglas).toUpperCase())
            formData.append('folios', this.folios)
            formData.append('asunto', String(this.asunto).toUpperCase())
            formData.append('adjuntos', String(this.adjuntos).toUpperCase())
            formData.append('urgencia',this.urgencia)
            formData.append('fechaDocumento', this.fechaDocumento)
            formData.append('emailOrigen', String(this.emailOrigen).toLowerCase())
            formData.append('celularOrigen', this.celularOrigen)
            formData.append('direccionOrigen', String().toUpperCase(this.direccionOrigen))
            if (document.getElementById('fileup').files[0]) {
                formData.append('archivo', document.getElementById('fileup').files[0])
            }
            return formData
        },
        async sendFormExternal() {
            this.isLoadend = true
            this.errores = {}
            const params = this.dataToBeSentExternal()
            try {
                const {data} = await axios.post('documento/insertExternal', params)
                this.isLoadend = false
                this.documento = data.documento
                this.accionDerivar(data,true)
                // $('#modalDerivarDocumentos').modal({
                //     keyboard: false,
                //     show: true,
                //     backdrop: 'static'
                // })
                console.log(data)
            } catch (error) {
                this.errores = error.response.data.errors
                console.log(error.response.data.errors)
                // console.log(errores.hasOwnProperty('nroDocumentoPersona'))

                $.toast({
                    heading: 'Corriga los errores',
                    text: error.response.data.errors,
                    icon: 'error',
                    position: 'top-right',
                    hideAfter: 10000
                })
                this.isLoadend = false
            }
        },
        async derivar() {
            if(this.listAreasDerivar.length <= 0){
                return
            }
            this.isLoadend = true
            const params = {
                idDocumento :this.documento.id,
                derivaciones : this.listAreasDerivar
            }
            try {
                await axios.post('/documento/derivar', params)
                this.isLoadend = false
                await Swal.fire({ icon: 'success', title: 'Bien', text: 'El Proceso se realizo correctamente' })
                window.location.replace('/')

            } catch (error) {
                this.isLoadend = false
                await Swal.fire({ icon: 'error', title: 'Espera!', html: '<span style="line-height:17px !important;font-size:15px !important">No se puede realizar las derivaciones<br><small>Asegurate que el documento que intentas derivar este en tu bandeja de documentos en proceso</small></span>' })
                window.location.replace('/')
                // $('#modalDerivarDocumentos').modal('hide')
            }   
        },
        async buscarApi(){
            if(!this.validateDataPeruApi()){
                Swal.fire(
                    'Error',
                    'Ingrese correctamente el numero de documento.',
                    'error'
                )
                return
            }
            this.isLoadend = true
            try {
                const response = await axios.get('/consulta/api/'+this.tipoDocumentoPersona+"/"+this.nroDocumentoPersona);
                // await axios.post('/consulta/api/',arams)
                this.isLoadend = false
                if(response.data.id){
                    this.fullName = response.data.fullName
                    this.direccionOrigen = response.data.direccion
                    await Swal.fire({ icon: 'success', title: 'Bien', html: 'Datos encontrados <br><strong>'+this.fullName +'</strong>' })
                }
                else{
                     await Swal.fire({ icon: 'error', title: 'Espera!', html: 'los datos no se encontraron, ingrese manualmente' })
                // window.location.replace('/')
                }

            } catch (error) {
                this.isLoadend = false
                await Swal.fire({ icon: 'error', title: 'Espera!', html: 'los datos no se encontraron, ingrese manualmente' })
                // window.location.replace('/')
                // $('#modalDerivarDocumentos').modal('hide')
            }   
        },
        validateDataPeruApi(){
            if(this.tipoDocumentoPersona == 'dni' && this.nroDocumentoPersona.length == 8){
                return true
            }
            else if(this.tipoDocumentoPersona == 'ruc' && this.nroDocumentoPersona.length == 11){
                return true
            } 
            else{
                return false
            }
        },
        isDerivado(status){
            if (status == true){
                window.location.replace('/')
            }
        },
    },
}
