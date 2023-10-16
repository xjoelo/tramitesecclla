
import UserService from '@/services/UserService'
import GenericTablesService from '@/services/GenericTablesService'
import DocumentoService from '@/services/DocumentoService'


import VueHtml2pdf from 'vue-html2pdf'

export default {
	name: 'SfEnProceso',
	components:{
        'vue-pdf':VueHtml2pdf,
	},
	props: ['user'],
	data() {
		return {
            searchBy:1,
            inputSearch:'',

            nroPorPagina:20,

            procesando:false,

            listDocumetos :{},
            documentoSelected : null,
            file:null,
            urlDocumentoTramite:'',
            documento:null,
            documentoEditSelect:null
        };
	},
	created(){
       this.getListDocumentos()
	},
	mounted(){        
	    $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
    },
	filters:{

	},
	watch:{
        nroPorPagina(newVal,oldVal){
            this.getListDocumentos()
        },
	},
	computed:{

	},
	methods:{
        openModalEdiar(operacion){
            this.documentoEditSelect = operacion
            this.folios = operacion.documento.folios
            this.asunto = operacion.documento.asunto
            this.adjuntos = operacion.documento.adjuntos
            this.idEditar = operacion.documento.id
            $("#modalEditarDocumento").modal({backdrop: 'static', keyboard: false})
            
        },
        comprobarEditar(operacion){
            if(!operacion.idProcesado &&  this.user.id == operacion.documento.idUser && operacion.documento.idDependencia == this.user.dependencia.id ){
                return true
            }
            return false
        },
        accionDerivar(operacion){
            this.operacion = operacion
            this.$refs.derivarComponent.showDerivar(this.operacion);
        },
        accionArchivar(operacion){
            this.operacion = operacion
            this.$refs.archivarComponent.showArchivar(this.operacion);
        },
        onProgress(event){
            this.procesando=true
            if(event>=100){
                this.procesando=false
            }
            console.log(event);
        },
        generateReport () {
            this.$refs.html2Pdf.generatePdf()
        },
        generateReportMovil(){
            this.$refs.html2PdfMovil.generatePdf()
        },
        setFile(file){
            this.file = file
        },
        async getListDocumentos(page=1) {
            this.procesando = true
            let params = {
                searchBy: this.searchBy,
                inputSearch: this.inputSearch,
            }
            const { data } = await DocumentoService.listarEnProceso(page,this.nroPorPagina,params)
            this.listDocumetos = data
            this.procesando = false
        },
        mostrarDetalles(documento){
            this.documentoSelected = documento
            this.urlDocumentoTramite = '/seguimiento-externo/'+ documento.documento.id
            this.setFile('/storage/tramite_virtual/' + this.documentoSelected.documento.archivo)
            $("#modalDetalleDocumento").modal({backdrop: 'static', keyboard: false})
        }, 
        isDerivado(status){
            if (status == true){
                this.getListDocumentos()
            }
        },
    }
};
