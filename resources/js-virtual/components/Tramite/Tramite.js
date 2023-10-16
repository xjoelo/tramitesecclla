import GenericTableServices from "@2/services/GenericTablesService.js"
import TramiteService from "@2/services/TramiteVirtualService.js"

export default {
    name: "SfTramiteVirtual",
    components: {},
    props: [],
    data() {
        return {
            procesando: false,
            tipoPersona: 1,
            tipoDocumentoPersona: 'dni',
            nroDocumentoPersona: '',
            fullName: '',
            firma: '',
            cargoFirma: '',

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
            adjuntos:null,

            listTypeDocuments: [],
        };
    },
    mounted() {
        this.getListAllTypeDocuments()
        // $('#modalAdvertencia').modal('show');
        $('#modalAdvertencia').modal({
            keyboard: false,
            show: true,
            backdrop: 'static'
        })
    },
    filters: {},
    watch: {
        tipoPersona(newValue, oldValue) {
            if (newValue == 2) {
                this.tipoDocumentoPersona = 'ruc'
            } else {
                this.tipoDocumentoPersona = 'dni'
            }
        },
    },
    computed: {},
    methods: {
        async getListAllTypeDocuments() {
            try {
                const { data } = await GenericTableServices.listAll('tipo_documentos')
                this.listTypeDocuments = await data
                this.idTipoDocumento = data[0].id
            } catch (error) {

            }
        },
        dataToBeSent() {
            // String().toUpperCase()
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
            formData.append('fechaDocumento', this.fechaDocumento)
            formData.append('emailOrigen', String(this.emailOrigen).toLowerCase())
            formData.append('celularOrigen', this.celularOrigen)
            formData.append('direccionOrigen', String(this.direccionOrigen).toUpperCase())
            if (document.getElementById('fileup').files[0]) {
                formData.append('archivo', document.getElementById('fileup').files[0])
            }
            return formData
        },
        async sendForm() {
            this.procesando = true
            const params = this.dataToBeSent()
            try {
                const res = await TramiteService.insert(params)
                if (res.errors) {
                    // const normalizeErrors = Object.keys(res.errors).map(item => item)
                    // normalizeErrors.forEach(error => {
                    //   document.getElementById(error).classList.add('input-error')
                    // })
                    $.toast({
                        heading: 'Corriga los errores',
                        text: res.errors,
                        icon: 'error',
                        position: 'top-right',
                        hideAfter: 10000
                    })
                    this.procesando = false
                    return
                } else if (res.data && res.data.id) {
                    
                    // await Swal.fire({ icon: 'success', title: 'Bien', text: 'El Proceso se realizo correctamente' })
                    window.location.href = `/tramite-virtual-registrado/${res.data.id}/${res.data.nroDocumentoPersona}`
                    this.procesando = false
                } else {
                    this.procesando = false
                    Swal.fire({ icon: 'error', title: 'Espera', text: 'Algo salio mal, intentelo nuevamente' })
                }
            } catch (error) {
                console.log('mono')
                console.log(error)
                this.procesando = false
                // Swal.fire({icon: 'error',title: 'Espera',text: 'Algo salio mal, intentelo nuevamente'})
                // $.toast({
                //   heading: 'Corriga los errores',
                //   text: res.errors,
                //   icon: 'error',
                //   position: 'top-right',
                //   hideAfter: 10000
                // })
            }
        },
    }
};
