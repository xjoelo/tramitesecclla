
import UserService from '@/services/UserService'
import GenericTablesService from '@/services/GenericTablesService'
import DocumentoService from '@/services/DocumentoService'


import VueHtml2pdf from 'vue-html2pdf'

export default {
	name: 'SfPorRecibir',
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
        async recibirDocumento(documento){
            this.procesando = true
            const params = {
                idOperacion: documento.id,
            }
            try {
                await axios.post('/documento/recibir', params)
                this.procesando = false
                this.getListDocumentos()
                Swal.fire({ icon: 'success', title: 'Bien', text: 'El Proceso se realizo correctamente' })   

            }catch (error) {
                this.procesando = false
                await Swal.fire({ icon: 'error', title: 'Espera!', html: '<span style="line-height:17px !important;font-size:15px !important">No se puede realizar la operación<br><small>Asegurate que el documento que intenta archivar este en tu bandeja de documentos en proceso</small></span>' })
            }   
        },
        antesRecibir(documento){
            Swal.fire({
                title: '¡Espera!',
                html: "Desea recibir el documento<br><span class='format-numero'>"+documento.documento.full_nro_registro+"</span><br><small class='format-numero'>"+ documento.documento.full_documento +"</small>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Recibir',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.recibirDocumento(documento)
                }
            })
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
            const { data } = await DocumentoService.listarPorRecibir(page,this.nroPorPagina,params)
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
